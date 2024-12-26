<?php

use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\CustomerStoreController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->as('api.')
    ->group(function () {
        Route::get('/user', CurrentUserController::class)->name('user');

        Route::post('/customers/store', CustomerStoreController::class)->name('customers.store');
    });
