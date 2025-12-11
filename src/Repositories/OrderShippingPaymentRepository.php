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

    public function syncPayments(int $shippingId, array $payments): void
    {
        $shipping = OrderShipping::query()->findOrFail($shippingId);
        $ids = [];
        foreach ($payments as $item) {
            if (is_array($item)) {
                $pid = (int) ($item['payment_id'] ?? $item['id'] ?? 0);
                if ($pid > 0) {
                    $ids[] = $pid;
                }
            } else {
                $pid = (int) $item;
                if ($pid > 0) {
                    $ids[] = $pid;
                }
            }
        }
        $shipping->payments()->sync($ids);
    }

    public function syncShippings(int $paymentId, array $shippings): void
    {
        $payment = OrderPayment::query()->findOrFail($paymentId);
        $ids = [];
        foreach ($shippings as $item) {
            if (is_array($item)) {
                $sid = (int) ($item['shipping_id'] ?? $item['id'] ?? 0);
                if ($sid > 0) {
                    $ids[] = $sid;
                }
            } else {
                $sid = (int) $item;
                if ($sid > 0) {
                    $ids[] = $sid;
                }
            }
        }
        $payment->shippings()->sync($ids);
    }
}
