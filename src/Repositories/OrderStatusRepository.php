<?php

namespace Molitor\Order\Repositories;

use Molitor\Order\Models\OrderStatus;

class OrderStatusRepository implements OrderStatusRepositoryInterface
{
    private OrderStatus $orderStatus;

    public function __construct()
    {
        $this->orderStatus = new OrderStatus();
    }

    public function getByName(string $name, int|string|null $language = null): ?OrderStatus
    {
        return $this->orderStatus->joinTranslation($language)->whereTranslation('name', $name)->first();
    }

    public function getOptions(): array
    {
        return $this->orderStatus
            ->get()
            ->mapWithKeys(function (OrderStatus $status) {
                $label = $status->name ?? null;
                if ($label === null || $label === '') {
                    $label = $status->code ?: ('#' . (string) $status->id);
                }
                return [$status->id => (string) $label];
            })
            ->toArray();
    }

    public function delete(OrderStatus $orderStatus): void
    {
        $orderStatus->delete();
    }

    public function getAll()
    {
        return $this->orderStatus->orderBy('name')->get();
    }

    public function getDefault(): OrderStatus
    {
        return $this->fundOrCreate('ordered', 'Megrendelve');
    }

    public function getByCode(string $code): OrderStatus|null
    {
        return $this->orderStatus->where('code', $code)->first();
    }

    /**
     * Ensure name fallback when creating/finding by code & name.
     */
    public function fundOrCreate(string $code, string $name, int|string|null $language = null): OrderStatus
    {
        $orderStatus = $this->getByCode($code);
        if ($orderStatus) {
            return $orderStatus;
        }

        $name = ($name === null || $name === '') ? $code : $name;

        $orderStatus = $this->getByName($name, $language);
        if ($orderStatus) {
            return $orderStatus;
        }

        return $this->orderStatus->create([
            'code' => $code,
        ]);
    }
}
