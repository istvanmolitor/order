<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderPayment;

interface OrderPaymentRepositoryInterface
{
    public function getByCode(string $code): OrderPayment|null;

    public function getByName(string $name): ?OrderPayment;

    public function getOptions(): array;

    public function getAllIds(): array;

    public function delete(OrderPayment $orderPayment);

    public function getAll();
}
