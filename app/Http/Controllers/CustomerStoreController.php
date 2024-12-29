<?php

namespace App\Http\Controllers;

use App\Contract\CustomerContract;
use App\Enums\CustomerTypeEnum;
use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use App\Models\Organization;
use App\Models\People;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CustomerStoreController extends Controller
{
    public function __invoke(CustomerStoreRequest $request): JsonResponse
    {
        $result = DB::transaction(function () use ($request) {
            return match ($request->validated('type')) {
                CustomerTypeEnum::CPF->value => $this->createPeopleCustomer($request->validated()),
                CustomerTypeEnum::CNPJ->value => $this->createOrganizationCustomer($request->validated()),
            };
        });

        return response()->json($result, Response::HTTP_CREATED);
    }

    private function createPeopleCustomer(array $inputs): Customer
    {
        $people = People::query()->create([
            'first_name' => data_get($inputs, 'first_name'),
            'last_name' => data_get($inputs, 'last_name'),
            'cpf' => data_get($inputs, 'cpf'),
        ]);

        $this->createAddressesContacts($people, $inputs);

        return $this->createCustomer($people, $inputs);
    }

    private function createOrganizationCustomer(array $inputs): Customer
    {

        $organization = Organization::query()->create([
            'name' => data_get($inputs, 'name'),
            'legal_name' => data_get($inputs, 'legal_name'),
            'cnpj' => data_get($inputs, 'cnpj'),
        ]);

        $this->createAddressesContacts($organization, $inputs);

        return $this->createCustomer($organization, $inputs);
    }

    private function createAddressesContacts(People | Organization $relationship, array $inputs): void
    {
        $relationship->addresses()->createMany(data_get($inputs, 'addresses'));
        $relationship->contacts()->createMany(data_get($inputs, 'contacts'));
    }

    private function createCustomer(CustomerContract $relationship, array $inputs): Customer
    {
        return $relationship->customer()->create(['type' => data_get($inputs, 'type')]);
    }
}

