<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\Order;
use Molitor\Customer\Models\Customer;
use Molitor\Currency\Models\Currency;
use Molitor\Order\Models\OrderStatus;

interface OrderRepositoryInterface
{
    public function delete(Order $order): void;

    public function create(string $code, Customer $customer, Currency $currency, OrderStatus $orderStatus): Order;

    public function getByCode(string $code): ?Order;

    public function codeExists(string $code): bool;

    public function generateCode(): string;
}
