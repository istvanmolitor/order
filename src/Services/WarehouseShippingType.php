<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Validator;

class WarehouseShippingType extends ShippingType
{

    public function getName(): string
    {
        return 'warehouse';
    }

    public function getLabel(): string
    {
        return __('order::common.warehouse');
    }

    public function getForm(): array
    {
        return [
            TextInput::make('shipping_data.contact_name')
                ->label(__('order::common.contact_name'))
                ->required()
                ->maxLength(255),
            TextInput::make('shipping_data.pickup_time')
                ->label(__('order::common.pickup_time'))
                ->maxLength(255),
        ];
    }
}
