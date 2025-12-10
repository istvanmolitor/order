<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderPayment;
use Molitor\Order\Models\OrderShipping;
use Molitor\Order\Models\OrderShippingPayment;

class OrderShippingPaymentRepository implements OrderShippingPaymentRepositoryInterface
{
    public function attach(int $shippingId, int $paymentId): void
    {
        OrderShippingPayment::firstOrCreate([
            'order_shipping_id' => $shippingId,
            'order_payment_id' => $paymentId,
        ]);
    }

    public function detach(int $shippingId, int $paymentId): void
    {
        OrderShippingPayment::where('order_shipping_id', $shippingId)
            ->where('order_payment_id', $paymentId)
            ->delete();
    }

    public function syncPayments(int $shippingId, array $paymentIds): void
    {
        $shipping = OrderShipping::query()->findOrFail($shippingId);
        $shipping->payments()->sync($paymentIds);
    }

    public function syncShippings(int $paymentId, array $shippingIds): void
    {
        $payment = OrderPayment::query()->findOrFail($paymentId);
        $payment->shippings()->sync($shippingIds);
    }
}
