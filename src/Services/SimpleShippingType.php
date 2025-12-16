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

    public function prepare(array $data): array
    {
        return [
            'contact' => $data['contact'] ?? null,
        ];
    }

    public function fill(array $formData, ?array $shippingData): array
    {
        if (is_array($shippingData)) {
            $formData['contact'] = $shippingData['contact'] ?? null;
        } elseif (is_string($shippingData) || is_numeric($shippingData)) {
            // Backward compatibility if stored as scalar
            $formData['contact'] = (string) $shippingData;
        }
        return $formData;
    }
}
