<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;

class OrderPayment extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderPaymentTranslation::class;
    }

    protected $fillable = [
        'code',
    ];

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
