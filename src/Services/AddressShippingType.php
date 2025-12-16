<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Validator;
use Molitor\Address\Filament\Components\Address;

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
            Address::make('address', __('order::common.address'))
        ];
    }

    public function prepare(array $data): array
    {
        return $data['address'] ?? [];
    }

    public function fill(array $formData, ?array $shippingData): array
    {
        if (!empty($shippingData)) {
            $formData['address'] = $shippingData;
        }
        return $formData;
    }
}
