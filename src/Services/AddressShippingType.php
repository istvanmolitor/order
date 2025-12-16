<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
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

    public function validate(array $data): array
    {
        return Validator::make($data, [
            'address' => ['required', 'array'],
            'address.name' => ['required', 'string', 'max:255'],
            'address.country_id' => ['required', 'integer', 'exists:countries,id'],
            'address.zip_code' => ['required', 'string', 'max:10'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.address' => ['required', 'string', 'max:255'],
        ])->validate();
    }

    public function view(array $data): ViewContract|ViewFactory
    {
        return view('order::shipping.address', [
            'address' => $data['address'] ?? [],
        ]);
    }
}
