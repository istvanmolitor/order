<?php

use Illuminate\Support\Facades\Route;
use Molitor\Order\Http\Controllers\Api\OrderApiController;

Route::prefix('admin/order')
    ->middleware(['api', 'auth:sanctum'])
    ->name('order.')
    ->group(function () {
        Route::resource('orders', OrderApiController::class);
    });

