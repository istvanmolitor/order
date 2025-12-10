<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslationModel;

class OrderShippingTranslation extends TranslationModel
{
    public function getTranslatableModelClass(): string
    {
        return OrderShipping::class;
    }

    public function getTranslationForeignKey(): string
    {
        return 'order_shipping_id';
    }

    public function getTranslatableFields(): array
    {
        return [
            'name',
            'description',
        ];
    }
}
