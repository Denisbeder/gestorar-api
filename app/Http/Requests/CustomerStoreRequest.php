<?php

namespace App\Http\Requests;

use App\Enums\AddressTypeEnum;
use App\Enums\ContactTypeEnum;
use App\Enums\CustomerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;

class CustomerStoreRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $validator = $this->getValidatorInstance();
        $phoneRegex = config('phone.regex');

        $validator->sometimes('contacts.*.value', 'email', fn (Fluent $input, Fluent $item) => $item->type === 'email');

        $validator->sometimes('contacts.*.value', "regex:{$phoneRegex}", fn (Fluent $input, Fluent $item) => $item->type === 'phone');
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
    public function rules(): array
    {
        $typeCPF = CustomerTypeEnum::CPF->value;
        $typeCNPJ = CustomerTypeEnum::CNPJ->value;



        return [
            'type' => ['required', Rule::enum(CustomerTypeEnum::class)],

            // Person
            'first_name' => ["exclude_unless:type,{$typeCPF}", 'string', 'max:50'],
            'last_name' => ["exclude_unless:type,{$typeCPF}", 'sometimes', 'nullable', 'string', 'max:100'],
            'cpf' => ["exclude_unless:type,{$typeCPF}", 'sometimes', 'nullable', 'numeric', 'digits:11'],

            // Company
            'name' => ["exclude_unless:type,{$typeCNPJ}", 'required', 'string', 'max:180'],
            'legal_name' => ["exclude_unless:type,{$typeCNPJ}", 'sometimes', 'nullable', 'string', 'max:100'],
            'cnpj' => ["exclude_unless:type,{$typeCNPJ}", 'sometimes', 'nullable', 'numeric', 'digits:14'],

            // Common
            'addresses' => ['sometimes', 'array'],
            'addresses.*.type' => ['sometimes', 'required', Rule::enum(AddressTypeEnum::class)],
            'addresses.*.zipcode' => ['sometimes', 'nullable', 'numeric', 'digits:8'],
            'addresses.*.street' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.number' => ['sometimes', 'required', 'string', 'max:10'],
            'addresses.*.neighborhood' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.city' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.state' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.complement' => ['sometimes', 'nullable', 'string', 'max:100'],

            'contacts' => ['sometimes', 'array'],
            'contacts.*.type' => ['sometimes', 'nullable', Rule::enum(ContactTypeEnum::class)],
            'contacts.*.value' => ['sometimes', 'string', 'required', 'max:180'],
            'contacts.*.description' => ['sometimes', 'nullable', 'string', 'max:50'],
            'contacts.*.properties' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
