<?php

namespace Molitor\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Molitor\Currency\Events\DefaultCurrencyChanged;
use Molitor\Order\Listeners\DefaultCurrencyChangedListener;
use Molitor\Order\Repositories\OrderRepositoryInterface;
use Molitor\Order\Repositories\OrderRepository;
use Molitor\Order\Repositories\OrderStatusRepositoryInterface;
use Molitor\Order\Repositories\OrderStatusRepository;
use Molitor\Order\Repositories\OrderItemRepositoryInterface;
use Molitor\Order\Repositories\OrderItemRepository;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;
use Molitor\Order\Repositories\OrderPaymentRepository;
use Molitor\Order\Repositories\OrderShippingRepositoryInterface;
use Molitor\Order\Repositories\OrderShippingRepository;
use Molitor\Order\Repositories\OrderShippingPaymentRepositoryInterface;
use Molitor\Order\Repositories\OrderShippingPaymentRepository;

class OrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'order');

        // Subscribe to currency default change to recalculate stored shipping prices
        Event::listen(DefaultCurrencyChanged::class, [DefaultCurrencyChangedListener::class, 'handle']);
    }

    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderStatusRepositoryInterface::class, OrderStatusRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(OrderPaymentRepositoryInterface::class, OrderPaymentRepository::class);
        $this->app->bind(OrderShippingRepositoryInterface::class, OrderShippingRepository::class);
        $this->app->bind(OrderShippingPaymentRepositoryInterface::class, OrderShippingPaymentRepository::class);
    }
}
