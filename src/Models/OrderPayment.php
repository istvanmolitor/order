<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Molitor\Currency\Services\Price;

class OrderPayment extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderPaymentTranslation::class;
    }

    protected $fillable = [
        'code',
        'color',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function __toString(): string
    {
        return (string) $this->name;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price->exchangeDefault()->price;
    }

    public function getPrice(): Price
    {
        return new Price($this->price, null);
    }

    public function shippings(): BelongsToMany
    {
        return $this->belongsToMany(OrderShipping::class, 'order_shipping_payments', 'order_payment_id', 'order_shipping_id');
    }
}
