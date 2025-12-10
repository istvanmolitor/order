<?php

namespace Molitor\Order\Models;

use Molitor\Language\Models\TranslationModel;

class OrderPaymentTranslation extends TranslationModel
{
    public function getTranslatableModelClass(): string
    {
        return OrderPayment::class;
    }

    public function getTranslationForeignKey(): string
    {
        return 'order_payment_id';
    }

    public function getTranslatableFields(): array
    {
        return [
            'name',
            'description',
        ];
    }
}
