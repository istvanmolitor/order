<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Validator;
use Molitor\Address\Filament\Components\Address;
use Molitor\Address\Repositories\CountryRepositoryInterface;

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

    public function validate(array $data): array
    {
        return Validator::make($data, [
            'address' => ['required', 'array'],
            'address.name' => ['required', 'string', 'max:255'],
            'address.country_id' => ['required', 'integer', 'exists:countries,id'],
            'address.zip_code' => ['required', 'string', 'max:10'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.address' => ['required', 'string', 'max:255'],
        ], [
            'address.required' => __('order::validation.address.required'),
            'address.name.required' => __('order::validation.address.name.required'),
            'address.name.max' => __('order::validation.address.name.max'),
            'address.country_id.required' => __('order::validation.address.country_id.required'),
            'address.country_id.exists' => __('order::validation.address.country_id.exists'),
            'address.zip_code.required' => __('order::validation.address.zip_code.required'),
            'address.zip_code.max' => __('order::validation.address.zip_code.max'),
            'address.city.required' => __('order::validation.address.city.required'),
            'address.city.max' => __('order::validation.address.city.max'),
            'address.address.required' => __('order::validation.address.address.required'),
            'address.address.max' => __('order::validation.address.address.max'),
        ])->validate();
    }

    public function getLivewireComponent(): string
    {
        return 'order::address-shipping-component';
    }
}
