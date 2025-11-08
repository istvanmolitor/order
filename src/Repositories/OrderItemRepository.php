<?php

namespace Molitor\Order\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Molitor\Order\Models\Order;
use Molitor\Order\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    private OrderItem $orderItem;

    public function __construct()
    {
        $this->orderItem = new OrderItem();
    }

    public function delete(OrderItem $orderItem): void
    {
        $orderItem->delete();
    }

    public function getOrderItemsByOrder(Order $order): Collection
    {
        return $this->orderItem->where('order_id', $order->id)->with(['product', 'currency'])->get();
    }

    public function saveItems(Order $order, array $rows): void
    {
        foreach ($rows as $index => $orderItemData) {
            if ($order->orderItems->has($index)) {
                $orderItem = $order->orderItems->get($index);
            } else {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
            }

            $orderItem->product_id = $orderItemData['product_id'];
            $orderItem->quantity = $orderItemData['quantity'];
            $orderItem->price = $orderItemData['price'];
            $orderItem->save();
        }

        /**
         * @var int $index
         * @var OrderItem $orderItem
         */
        foreach ($order->orderItems as $index => $orderItem) {
            if(!isset($request->orderItems[$index])) {
                $orderItem->delete();
            }
        }
    }
}
