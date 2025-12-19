<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Validator;

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

    public function validationRules(array $data): array
    {
        return [
            'contact' => ['required', 'string', 'max:255'],
        ];
    }

    public function getDefaultValues(): array
    {
        return [
            'contact' => '',
        ];
    }

    public function getFormTemplate(): string
    {
        return 'order::shipping.simple';
    }

    public function renderView(array $shippingData): string
    {
        return view('order::shipping.simple-display', [
            'data' => $shippingData,
        ])->render();
    }
}
