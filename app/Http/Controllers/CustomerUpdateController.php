<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerUpdateController
{
    public function __invoke(Customer $customer, Request $request): JsonResponse
    {
        $inputs = $request->all();

        $attributes = match ($customer->type->value) {
            CustomerTypeEnum::CPF->value =>[
                'first_name' => data_get($inputs, 'first_name'),
                'last_name' => data_get($inputs, 'last_name'),
                'cpf' => data_get($inputs, 'cpf'),
            ],
            CustomerTypeEnum::CNPJ->value => [
                'name' => data_get($inputs, 'name'),
                'legal_name' => data_get($inputs, 'legal_name'),
                'cnpj' => data_get($inputs, 'cnpj'),
            ],
        };

        $customer->customerable->update($attributes);

        foreach (data_get($inputs, 'addresses') as $address) {
            $customer->customerable
                ->addresses()
                ->where('id', data_get($address, 'id'))
                ->update([
                    'type' => data_get($address, 'type'),
                    'zipcode' => data_get($address, 'zipcode'),
                    'street' => data_get($address, 'street'),
                    'number' => data_get($address, 'number'),
                    'neighborhood' => data_get($address, 'neighborhood'),
                    'city' => data_get($address, 'city'),
                    'state' => data_get($address, 'state'),
                    'complement' => data_get($address, 'complement'),
                ]);
        }

        foreach (data_get($inputs, 'contacts') as $contact) {
            $customer->customerable
                ->contacts()
                ->where('id', data_get($contact, 'id'))
                ->update([
                    'type' => data_get($contact, 'type'),
                    'value' => data_get($contact, 'value'),
                    'description' => data_get($contact, 'description'),
                    'properties' => data_get($contact, 'properties'),
                ]);
        }

        return response()->json($customer);
    }
}
