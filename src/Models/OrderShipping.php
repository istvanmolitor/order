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
        'type',
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
        return new Price((float)$this->price, null);
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(OrderPayment::class, 'order_shipping_payments', 'order_shipping_id', 'order_payment_id');
    }

    protected static function booted(): void
    {
        static::updating(function (self $model) {
            // Prevent changing type after creation
            if ($model->isDirty('type')) {
                $model->type = $model->getOriginal('type');
            }
        });
    }
}
