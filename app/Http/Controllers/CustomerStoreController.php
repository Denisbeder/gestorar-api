<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\CustomerStoreRequest;
use App\Models\People;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CustomerStoreController extends Controller
{
    public function __invoke(CustomerStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            match ($request->validated('type')) {
                CustomerTypeEnum::CPF->value => $this->createPeopleCustomer($request->validated()),
                CustomerTypeEnum::CNPJ->value => $this->createCompanyCustomer($request->validated()),
            };
        });

        return response()->noContent();
    }

    private function createPeopleCustomer(array $inputs): void
    {
        $people = People::query()->create($inputs);

        $this->create($people, $inputs);
    }

    private function createCompanyCustomer(array $inputs): void
    {
        $company = Company::query()->create($inputs);

        $this->create($company, $inputs);
    }

    private function create(People $relationship, array $inputs): void
    {
        $relationship->addresses()->createMany(data_get($inputs, 'addresses'));
        //$relationship->contacts()->createMany(data_get($inputs, 'contacts'));
        //$relationship->customer()->create($relationship);
    }
}

