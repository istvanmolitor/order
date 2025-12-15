<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;

class SimpleShippingType extends ShippingType
{

    public function getName(): string
    {
        return 'simple';
    }

    public function getLabel(): string
    {
        return __('order::common.simple');
    }

    public function getForm(): array
    {
        return [
            Textarea::make('contact')
                ->label(__('order::common.contact'))
                ->required()
                ->maxLength(255),
        ];
    }
}
