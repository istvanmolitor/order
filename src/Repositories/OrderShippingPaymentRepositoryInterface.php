<?php

namespace Molitor\Order\Repositories;

interface OrderShippingPaymentRepositoryInterface
{
    public function attach(int $shippingId, int $paymentId): void;

    public function detach(int $shippingId, int $paymentId): void;

    public function syncPayments(int $shippingId, array $paymentIds): void;

    public function syncShippings(int $paymentId, array $shippingIds): void;
}
