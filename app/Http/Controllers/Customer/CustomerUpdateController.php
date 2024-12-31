<?php

namespace App\Http\Controllers\Customer;

use App\Enums\CustomerTypeEnum;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerUpdateController
{
    public function __invoke(Customer $customer, Request $request): JsonResponse
    {
        $inputs = $request->all();

        $addressAttributes = match ($customer->type->value) {
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

        $customer->customerable->update($addressAttributes);
        $this->deleteAddressesContacts($customer, $inputs);
        $this->updateAddressesContacts($customer, $inputs);

        $customer->load(['customerable', 'customerable.addresses', 'customerable.contacts']);

        return response()->json($customer);
    }

    private function deleteAddressesContacts(Customer $customer, array $inputs): void
    {
        $addressesIds = array_filter(data_get($inputs, 'addresses.*.id'));
        $contactsIds = array_filter(data_get($inputs, 'contacts.*.id'));

        $customer->customerable
            ->addresses()
            ->whereNotIn('id', $addressesIds)
            ->delete();

        $customer->customerable
            ->contacts()
            ->whereNotIn('id', $contactsIds)
            ->delete();
    }

    private function updateAddressesContacts(Customer $customer, array $inputs): void
    {
        $addressAttributes = array_map(fn ($address) => [
            'id' => data_get($address, 'id'),
            'type' => data_get($address, 'type'),
            'zipcode' => data_get($address, 'zipcode'),
            'street' => data_get($address, 'street'),
            'number' => data_get($address, 'number'),
            'neighborhood' => data_get($address, 'neighborhood'),
            'city' => data_get($address, 'city'),
            'state' => data_get($address, 'state'),
            'complement' => data_get($address, 'complement'),
            'addressable_type' => data_get($address, 'addressable_type'),
            'addressable_id' => data_get($address, 'addressable_id'),
        ], data_get($inputs, 'addresses'));

        $contactAttributes = array_map(fn ($contact) => [
            'id' => data_get($contact, 'id'),
            'type' => data_get($contact, 'type'),
            'value' => data_get($contact, 'value'),
            'description' => data_get($contact, 'description'),
            'properties' => ($properties = data_get($contact, 'properties')) ? json_encode($properties) : null,
            'contactable_type' => data_get($contact, 'contactable_type'),
            'contactable_id' => data_get($contact, 'contactable_id'),
        ], data_get($inputs, 'contacts'));

        $customer->customerable->addresses()->upsert($addressAttributes, 'id');
        $customer->customerable->contacts()->upsert($contactAttributes, 'id');
    }
}
