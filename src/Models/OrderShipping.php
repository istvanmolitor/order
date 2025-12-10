<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;

class OrderShipping extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderShippingTranslation::class;
    }

    protected $fillable = [
        'code',
    ];

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
