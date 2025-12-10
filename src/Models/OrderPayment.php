<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderPayment extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderPaymentTranslation::class;
    }

    protected $fillable = [
        'code',
        'color',
    ];

    public function __toString(): string
    {
        return (string) $this->name;
    }

    public function shippings(): BelongsToMany
    {
        return $this->belongsToMany(OrderShipping::class, 'order_shipping_payments', 'order_payment_id', 'order_shipping_id');
    }
}
