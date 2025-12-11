<?php

namespace Molitor\Order\Repositories;

interface OrderShippingPaymentRepositoryInterface
{
    public function attach(int $shippingId, int $paymentId): void;

    public function detach(int $shippingId, int $paymentId): void;

    public function syncPayments(int $shippingId, array $payments): void;

    public function syncShippings(int $paymentId, array $shippings): void;
}
