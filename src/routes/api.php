<?php

use Illuminate\Support\Facades\Route;
use Molitor\Order\Http\Controllers\Api\OrderApiController;
use Molitor\Order\Http\Controllers\Api\OrderPaymentApiController;
use Molitor\Order\Http\Controllers\Api\OrderShippingApiController;
use Molitor\Order\Http\Controllers\Api\OrderStatusApiController;

Route::prefix('admin/order')
    ->middleware(['api', 'auth:sanctum', 'permission:order'])
    ->name('order.')
    ->group(function () {
        Route::resource('orders', OrderApiController::class);
    });

Route::prefix('admin/order/order-statuses')
    ->middleware(['api', 'auth:sanctum', 'permission:order'])
    ->name('order-status.')
    ->group(function () {
        Route::get('/', [OrderStatusApiController::class, 'index']);
        Route::get('/create', [OrderStatusApiController::class, 'create']);
        Route::get('/{orderStatus}', [OrderStatusApiController::class, 'show']);
        Route::get('/{orderStatus}/edit', [OrderStatusApiController::class, 'edit']);
        Route::post('/', [OrderStatusApiController::class, 'store']);
        Route::put('/{orderStatus}', [OrderStatusApiController::class, 'update']);
        Route::delete('/{orderStatus}', [OrderStatusApiController::class, 'destroy']);
    });

Route::prefix('admin/order/order-payments')
    ->middleware(['api', 'auth:sanctum', 'permission:order'])
    ->name('order-payment.')
    ->group(function () {
        Route::get('/', [OrderPaymentApiController::class, 'index']);
        Route::get('/create', [OrderPaymentApiController::class, 'create']);
        Route::get('/{orderPayment}', [OrderPaymentApiController::class, 'show']);
        Route::get('/{orderPayment}/edit', [OrderPaymentApiController::class, 'edit']);
        Route::post('/', [OrderPaymentApiController::class, 'store']);
        Route::put('/{orderPayment}', [OrderPaymentApiController::class, 'update']);
        Route::delete('/{orderPayment}', [OrderPaymentApiController::class, 'destroy']);
    });

Route::prefix('admin/order/order-shippings')
    ->middleware(['api', 'auth:sanctum', 'permission:order'])
    ->name('order-shipping.')
    ->group(function () {
        Route::get('/', [OrderShippingApiController::class, 'index']);
        Route::get('/create', [OrderShippingApiController::class, 'create']);
        Route::get('/{orderShipping}', [OrderShippingApiController::class, 'show']);
        Route::get('/{orderShipping}/edit', [OrderShippingApiController::class, 'edit']);
        Route::post('/', [OrderShippingApiController::class, 'store']);
        Route::put('/{orderShipping}', [OrderShippingApiController::class, 'update']);
        Route::delete('/{orderShipping}', [OrderShippingApiController::class, 'destroy']);
    });
