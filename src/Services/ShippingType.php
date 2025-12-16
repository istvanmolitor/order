<?php

namespace Molitor\Order\Services;

abstract class ShippingType
{
    abstract public function getName(): string;

    abstract public function getLabel(): string;

    abstract public function getForm(): array;

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
