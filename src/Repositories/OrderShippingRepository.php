<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderShipping;

class OrderShippingRepository implements OrderShippingRepositoryInterface
{
    private OrderShipping $orderShipping;

    public function __construct()
    {
        $this->orderShipping = new OrderShipping();
    }

    public function getByName(string $name, int|string|null $language = null): ?OrderShipping
    {
        return $this->orderShipping->joinTranslation($language)->whereTranslation('name', $name)->first();
    }

    public function getOptions(): array
    {
        return $this->orderShipping
            ->get()
            ->mapWithKeys(function (OrderShipping $shipping) {
                $label = $shipping->name ?? null;
                if ($label === null || $label === '') {
                    $label = $shipping->code ?: ('#' . (string) $shipping->id);
                }
                return [$shipping->id => (string) $label];
            })
            ->toArray();
    }

    public function getAllIds(): array
    {
        return $this->orderShipping->pluck('id')->all();
    }

    public function delete(OrderShipping $orderShipping): void
    {
        $orderShipping->delete();
    }

    public function getAll()
    {
        return $this->orderShipping->joinTranslation()->orderByTranslation('name')->selectBase()->get();
    }

    public function getByCode(string $code): OrderShipping|null
    {
        return $this->orderShipping->where('code', $code)->first();
    }

    public function getById(int $shippingId): OrderShipping|null
    {
        return $this->orderShipping->where('id', $shippingId)->first();
    }
}
