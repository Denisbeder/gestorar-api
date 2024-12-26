<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
    public function rules(): array
    {
        return [
            'type' => ['required', 'in:cpf,cnpj'],

            // Person
            'first_name' => ['exclude_unless:type,cpf', 'string', 'max:50'],
            'last_name' => ['exclude_unless:type,cpf', 'sometimes', 'nullable', 'string', 'max:100'],
            'cpf' => ['exclude_unless:type,cpf', 'sometimes', 'nullable', 'numeric', 'digits:11'],

            // Company
            'name' => ['exclude_unless:type,cnpj', 'required', 'string', 'max:180'],
            'legal_name' => ['exclude_unless:type,cnpj', 'sometimes', 'nullable', 'string', 'max:100'],
            'cnpj' => ['exclude_unless:type,cnpj', 'sometimes', 'nullable', 'numeric', 'digits:14'],

            // Common
            'addresses' => ['sometimes', 'array'],
            'addresses.*.type' => ['sometimes', 'required', 'in:home,commercial,billing'],
            'addresses.*.zip_code' => ['sometimes', 'nullable', 'number', 'max:8'],
            'addresses.*.street' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.number' => ['sometimes', 'required', 'string', 'max:10'],
            'addresses.*.district' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.city' => ['sometimes', 'required', 'string', 'max:100'],
            'addresses.*.state' => ['sometimes', 'required', 'string', 'max:50'],
            'addresses.*.complement' => ['sometimes', 'nullable', 'string', 'max:100'],

            'contacts' => ['sometimes', 'array'],
            'contacts.*.value' => ['sometimes', 'required', 'string', 'max:180'],
            'contacts.*.type' => ['sometimes', 'nullable', 'in:email,phone'],

        ];
    }
}
