<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerShowController
{
    public function __invoke(Customer $customer): JsonResponse
    {
        $customer->load(['customerable', 'customerable.addresses', 'customerable.contacts']);

        return response()->json($customer);
    }
}
