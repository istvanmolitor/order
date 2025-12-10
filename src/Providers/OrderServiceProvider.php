<?php

namespace Molitor\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Order\Repositories\OrderRepositoryInterface;
use Molitor\Order\Repositories\OrderRepository;
use Molitor\Order\Repositories\OrderStatusRepositoryInterface;
use Molitor\Order\Repositories\OrderStatusRepository;
use Molitor\Order\Repositories\OrderItemRepositoryInterface;
use Molitor\Order\Repositories\OrderItemRepository;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;
use Molitor\Order\Repositories\OrderPaymentRepository;

class OrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'order');
    }

    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderStatusRepositoryInterface::class, OrderStatusRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(OrderPaymentRepositoryInterface::class, OrderPaymentRepository::class);
    }
}
