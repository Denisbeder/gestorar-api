<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerDestroyController
{
    public function __invoke(Customer $customer, Request $request): Response
    {
        sleep(3);
        $customer->delete();

        return response()->noContent();
    }
}
