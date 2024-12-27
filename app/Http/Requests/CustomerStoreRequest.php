<?php

namespace App\Http\Requests;

use App\Enums\CustomerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerStoreRequest extends FormRequest
{
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
            'addresses.*.type' => ['sometimes', 'required', 'in:home,commercial,billing'],
            'addresses.*.zipcode' => ['sometimes', 'nullable', 'numeric', 'min:8'],
            'addresses.*.street' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.number' => ['sometimes', 'required', 'string', 'max:10'],
            'addresses.*.neighborhood' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.city' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.state' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.complement' => ['sometimes', 'nullable', 'string', 'max:100'],

            'contacts' => ['sometimes', 'array'],
            'contacts.*.value' => ['sometimes', 'required', 'string', 'max:180'],
            'contacts.*.type' => ['sometimes', 'nullable', 'in:email,phone'],

        ];
    }
}
