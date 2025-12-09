<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderStatus;

interface OrderStatusRepositoryInterface
{
    public function getByCode(string $code): OrderStatus|null;

    public function getByName(string $name): ?OrderStatus;

    public function getOptions(): array;

    public function delete(OrderStatus $orderStatus);

    public function fundOrCreate(string $code, string $name): OrderStatus;

    public function getAll();

    public function getDefault(): ?OrderStatus;
}
