<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\CustomerStoreRequest;
use App\Models\Organization;
use App\Models\People;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerStoreController extends Controller
{
    public function __invoke(CustomerStoreRequest $request): Response
    {
        DB::transaction(function () use ($request) {
            match ($request->validated('type')) {
                CustomerTypeEnum::CPF->value => $this->createPeopleCustomer($request->validated()),
                CustomerTypeEnum::CNPJ->value => $this->createOrganizationCustomer($request->validated()),
            };
        });

        return response()->noContent();
    }

    private function createPeopleCustomer(array $inputs): void
    {
        $people = People::query()->create([
            'first_name' => data_get($inputs, 'first_name'),
            'last_name' => data_get($inputs, 'last_name'),
            'cpf' => data_get($inputs, 'cpf'),
        ]);

        $this->create($people, $inputs);
    }

    private function createOrganizationCustomer(array $inputs): void
    {

        $organization = Organization::query()->create([
            'name' => data_get($inputs, 'name'),
            'legal_name' => data_get($inputs, 'legal_name'),
            'cnpj' => data_get($inputs, 'cnpj'),
        ]);

        $this->create($organization, $inputs);
    }

    private function create(People | Organization $relationship, array $inputs): void
    {
        $relationship->addresses()->createMany(data_get($inputs, 'addresses'));
        $relationship->contacts()->createMany(data_get($inputs, 'contacts'));
        $relationship->customer()->create(['type' => data_get($inputs, 'type')]);
    }
}

