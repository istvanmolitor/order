<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslatableModel;

class OrderStatus extends TranslatableModel
{
    public function getTranslationModelClass(): string
    {
        return OrderStatusTranslation::class;
    }

    protected $fillable = [
        'code',
    ];

    public function __toString(): string
    {
        return $this->name;
    }
}
