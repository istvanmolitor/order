<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Molitor\Currency\Services\Price;

class OrderShipping extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderShippingTranslation::class;
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

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(OrderPayment::class, 'order_shipping_payments', 'order_shipping_id', 'order_payment_id');
    }
}
