<?php

namespace Molitor\Order\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Molitor\Order\Models\OrderStatus;

interface OrderStatusRepositoryInterface
{
    public function getByName(string $name): ?OrderStatus;

    public function getOptions(): array;

    public function delete(OrderStatus $orderStatus);

    public function fundOrCreate($name): OrderStatus;

    public function getAll();

    public function getDefault(): ?OrderStatus;
}
