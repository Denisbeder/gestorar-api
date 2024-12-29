<?php

use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\CustomerShowController;
use App\Http\Controllers\CustomerStoreController;
use App\Http\Controllers\CustomerUpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->as('api.')
    ->group(function () {
        Route::get('/user', CurrentUserController::class)->name('user');

        Route::post('/customers', CustomerStoreController::class)->name('customers.store');
        Route::put('/customers/{customer}', CustomerUpdateController::class)->name('customers.update');
        Route::get('/customers/{customer}', CustomerShowController::class)->name('customers.show');
    });
