<?php

namespace Molitor\Order\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Molitor\Order\Models\OrderStatus;

class OrderStatusRepository implements OrderStatusRepositoryInterface
{
    private OrderStatus $orderStatus;

    public function __construct()
    {
        $this->orderStatus = new OrderStatus();
    }

    public function getByName(string $name): ?OrderStatus
    {
        return $this->orderStatus->where('name', $name)->first();
    }

    public function getOptions(): array
    {
        return $this->orderStatus->get()->pluck('name', 'id')->toArray();
    }

    public function delete(OrderStatus $orderStatus)
    {
        $orderStatus->delete();
    }

    public function fundOrCreate($name): OrderStatus
    {
        $orderStatus = $this->getByName($name);
        if ($orderStatus) {
            return $orderStatus;
        }
        return $this->orderStatus->create(['name' => $name]);
    }

    public function getAll()
    {
        return $this->orderStatus->orderBy('name')->get();
    }

    public function getDefault(): ?OrderStatus
    {
        return $this->fundOrCreate('db');
    }
}
