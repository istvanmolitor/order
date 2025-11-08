<?php

namespace Molitor\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Molitor\Address\Models\Address;
use Molitor\Customer\Models\Customer;
use Molitor\Order\Repositories\OrderRepositoryInterface;

class Order extends Model
{
    protected $fillable = [
        'is_closed',
        'code',
        'customer_id',
        'currency_id',
        'order_status_id',
        'invoice_address_id',
        'shipping_address_id',
        'comment',
        'internal_comment',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->code)) {
                $orderRepository = app(OrderRepositoryInterface::class);
                $order->code = $orderRepository->generateCode();
            }
        });

        static::saving(function (Order $order) {
            if (empty($order->code)) {
                $orderRepository = app(OrderRepositoryInterface::class);
                $order->code = $orderRepository->generateCode();
            }
        });
    }

    public function __toString()
    {
        return $this->code;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function invoiceAddress()
    {
        return $this->belongsTo(Address::class, 'invoice_address_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}
