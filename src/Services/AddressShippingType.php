<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Validator;

class AddressShippingType extends ShippingType
{

    public function getName(): string
    {
        return 'address';
    }

    public function getLabel(): string
    {
        return __('order::common.address');
    }

    public function getForm(): array
    {
        return [
            TextInput::make('shipping_data.recipient_name')
                ->label(__('order::common.recipient_name'))
                ->required()
                ->maxLength(255),
            Textarea::make('shipping_data.note')
                ->label(__('order::common.note'))
                ->rows(3)
                ->maxLength(1000),
        ];
    }
}
