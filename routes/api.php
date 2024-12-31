<?php

use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\Customer\CustomerDestroyController;
use App\Http\Controllers\Customer\CustomerIndexController;
use App\Http\Controllers\Customer\CustomerShowController;
use App\Http\Controllers\Customer\CustomerStoreController;
use App\Http\Controllers\Customer\CustomerUpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->as('api.')
    ->group(function () {
        Route::get('/user', CurrentUserController::class)->name('user');

        Route::get('/customers', CustomerIndexController::class)->name('customers.index');
        Route::post('/customers', CustomerStoreController::class)->name('customers.store');
        Route::put('/customers/{customer}', CustomerUpdateController::class)->name('customers.update');
        Route::get('/customers/{customer}', CustomerShowController::class)->name('customers.show');
        Route::delete('/customers/{customer}', CustomerDestroyController::class)->name('customers.destroy');
    });
