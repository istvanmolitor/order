<?php

namespace Molitor\Order\Services;

use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;

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

    public function validate(array $data): array
    {
        return Validator::make($data, [
            'contact' => ['required', 'string', 'max:255'],
        ])->validate();
    }

    public function view(array $data): ViewFactory|ViewContract
    {
        return view('order::shipping.simple', [
            'contact' => $data['contact'] ?? '',
        ]);
    }
}
