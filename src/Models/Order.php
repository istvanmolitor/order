<?php

namespace Molitor\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Molitor\Address\Repositories\AddressRepositoryInterface;
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
        'order_payment_id',
        'order_shipping_id',
        'invoice_address_id',
        'shipping_address_id',
        'shipping_data',
        'comment',
        'internal_comment',
        'phone',
        'referer',
        'invoice',
    ];

    protected $casts = [
        'shipping_data' => 'array',
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

        static::deleted(function (Order $order) {
            /** @var AddressRepositoryInterface $addressRepository */
            $addressRepository = app(AddressRepositoryInterface::class);

            if ($order->relationLoaded('invoiceAddress')) {
                $invoiceAddress = $order->getRelation('invoiceAddress');
            } else {
                $invoiceAddress = $order->invoiceAddress;
            }
            if ($invoiceAddress instanceof Address) {
                $addressRepository->delete($invoiceAddress);
            }

            if ($order->relationLoaded('shippingAddress')) {
                $shippingAddress = $order->getRelation('shippingAddress');
            } else {
                $shippingAddress = $order->shippingAddress;
            }
            if ($shippingAddress instanceof Address) {
                $addressRepository->delete($shippingAddress);
            }
        });
    }

    public function __toString(): string
    {
        return $this->code;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function invoiceAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'invoice_address_id');
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function orderPayment(): BelongsTo
    {
        return $this->belongsTo(OrderPayment::class, 'order_payment_id');
    }

    public function orderShipping(): BelongsTo
    {
        return $this->belongsTo(OrderShipping::class, 'order_shipping_id');
    }
}
