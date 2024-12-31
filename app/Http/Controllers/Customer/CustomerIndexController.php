<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerIndexController
{
    public function __invoke(): JsonResponse
    {
        $customer = Customer::query()
            ->with('customerable')
            ->paginate()
            ->through(fn (Customer $customer) => $customer->append('name'));

        return response()->json($customer);
    }
}
