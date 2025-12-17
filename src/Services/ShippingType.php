<?php

namespace Molitor\Order\Services;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;

abstract class ShippingType
{
    abstract public function getName(): string;

    abstract public function getLabel(): string;

    abstract public function getForm(): array;

    abstract public function validate(array $data): array;

    abstract public function view(array $data): ViewContract|ViewFactory;

    abstract public function getLivewireComponent(): string;

    public function prepare(array $data): array
    {
        return $data;
    }

    public function fill(array $formData, ?array $shippingData): array
    {
        return $formData;
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
