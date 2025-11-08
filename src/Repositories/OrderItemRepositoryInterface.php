<?php

namespace Molitor\Order\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Molitor\Order\Models\Order;
use Molitor\Order\Models\OrderItem;

interface OrderItemRepositoryInterface
{
    public function delete(OrderItem $orderItem): void;

    public function getOrderItemsByOrder(Order $order): Collection;

    public function saveItems(Order $order, array $rows): void;
}
