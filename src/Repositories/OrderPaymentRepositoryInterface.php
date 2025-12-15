<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderPayment;

interface OrderPaymentRepositoryInterface
{
    public function getByCode(string $code): OrderPayment|null;

    public function getByName(string $name): ?OrderPayment;

    public function getOptions(): array;

    /**
     * Get payment options filtered by shipping method.
     *
     * @param int $orderShippingId
     * @return array<int,string>
     */
    public function getOptionsByShippingId(int $orderShippingId): array;

    public function getAllIds(): array;

    public function delete(OrderPayment $orderPayment);

    public function getAll();

    /**
     * Get payment methods allowed for the given shipping method.
     *
     * @param int $orderShippingId
     * @return \Illuminate\Support\Collection|OrderPayment[]
     */
    public function getByShippingId(int $orderShippingId);
}
