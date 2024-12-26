<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;

class CustomerStoreController extends Controller
{
    public function __invoke(CustomerStoreRequest $request)
    {
        sleep(10);
        return response()->json($request->validated());
    }
}

