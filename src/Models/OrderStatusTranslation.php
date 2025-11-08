<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslationModel;

class OrderStatusTranslation extends TranslationModel
{
    public function getTranslatableModelClass(): string
    {
        return OrderStatus::class;
    }

    public function getTranslationForeignKey(): string
    {
        return 'order_status_id';
    }

    public function getTranslatableFields(): array
    {
        return [
            'name',
            'description',
        ];
    }
}
