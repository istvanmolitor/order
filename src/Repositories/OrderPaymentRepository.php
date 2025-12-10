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

    public function getByName(string $name, int|string|null $language = null): ?OrderPayment
    {
        return $this->orderPayment->joinTranslation($language)->whereTranslation('name', $name)->first();
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

    public function delete(OrderPayment $orderPayment): void
    {
        $orderPayment->delete();
    }

    public function getAll()
    {
        return $this->orderPayment->orderBy('name')->get();
    }

    public function getByCode(string $code): OrderPayment|null
    {
        return $this->orderPayment->where('code', $code)->first();
    }
}
