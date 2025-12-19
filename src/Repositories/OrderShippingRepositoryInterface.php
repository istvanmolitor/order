<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderShipping;

interface OrderShippingRepositoryInterface
{
    public function getByCode(string $code): OrderShipping|null;

    public function getByName(string $name): ?OrderShipping;

    public function getOptions(): array;

    public function getAllIds(): array;

    public function delete(OrderShipping $orderShipping);

    public function getAll();

    public function getById(int $shippingId): OrderShipping|null;
}
