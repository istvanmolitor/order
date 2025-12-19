<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderPayment;

class OrderPaymentRepository implements OrderPaymentRepositoryInterface
{
    private OrderPayment $orderPayment;

    public function __construct()
    {
        $this->orderPayment = new OrderPayment();
    }

    public function getByName(string $name): ?OrderPayment
    {
        return $this->orderPayment->joinTranslation()->whereTranslation('name', $name)->first();
    }

    public function getOptions(): array
    {
        return $this->orderPayment
            ->get()
            ->mapWithKeys(function (OrderPayment $payment) {
                $label = $payment->name ?? null;
                if ($label === null || $label === '') {
                    $label = $payment->code ?: ('#' . (string) $payment->id);
                }
                return [$payment->id => (string) $label];
            })
            ->toArray();
    }

    public function getOptionsByShippingId(int $orderShippingId): array
    {
        return $this->getByShippingId($orderShippingId)
            ->mapWithKeys(function (OrderPayment $payment) {
                $label = $payment->name ?? null;
                if ($label === null || $label === '') {
                    $label = $payment->code ?: ('#' . (string) $payment->id);
                }
                return [$payment->id => (string) $label];
            })
            ->toArray();
    }

    public function getAllIds(): array
    {
        return $this->orderPayment->pluck('id')->all();
    }

    public function delete(OrderPayment $orderPayment): void
    {
        $orderPayment->delete();
    }

    public function getAll()
    {
        return $this->orderPayment->joinTranslation()->orderByTranslation('name')->selectBase()->get();
    }

    public function getByCode(string $code): OrderPayment|null
    {
        return $this->orderPayment->where('code', $code)->first();
    }

    public function getByShippingId(int $orderShippingId)
    {
        return $this->orderPayment
            ->joinTranslation()
            ->whereHas('shippings', function ($q) use ($orderShippingId) {
                $q->where('order_shippings.id', $orderShippingId);
            })
            ->orderByTranslation('name')
            ->selectBase()
            ->get();
    }

    public function getById(int $paymentId): OrderPayment|null
    {
        return $this->orderPayment->where('id', $paymentId)->first();
    }
}
