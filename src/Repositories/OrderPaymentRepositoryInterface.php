<?php

namespace Molitor\Order\Repositories;

use Illuminate\Support\Collection;
use Molitor\Order\Models\OrderPayment;

interface OrderPaymentRepositoryInterface
{
    public function getByCode(string $code): ?OrderPayment;

    public function getByName(string $name): ?OrderPayment;

    public function getOptions(): array;

    /**
     * Get payment options filtered by shipping method.
     *
     * @return array<int,string>
     */
    public function getOptionsByShippingId(int $orderShippingId): array;

    public function getAllIds(): array;

    public function delete(OrderPayment $orderPayment);

    public function getAll();

    /**
     * Get payment methods allowed for the given shipping method.
     *
     * @return Collection|OrderPayment[]
     */
    public function getByShippingId(int $orderShippingId);

    public function getById(int $paymentId): ?OrderPayment;
}
