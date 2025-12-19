<?php

namespace Molitor\Order\Services;

abstract class ShippingType
{
    abstract public function getName(): string;

    abstract public function getLabel(): string;

    abstract public function getForm(): array;

    abstract public function validationRules(array $data): array;

    public function isEnabled(): bool
    {
        return true;
    }

    public function prepare(array $data): array
    {
        return $data;
    }

    public function fill(array $formData, ?array $shippingData): array
    {
        if (empty($shippingData)) {
            $formData = $this->getDefaultValues();
        } else {
            $formData = $shippingData;
        }
        return $formData;
    }

    abstract public function getDefaultValues(): array;

    abstract public function getFormTemplate(): string;

    public function getFormTemplateData(): array
    {
        return [];
    }

    public function getAction(): string|null
    {
        return null;
    }

    /**
     * Render the view for displaying shipping data (e.g., on finalize page)
     *
     * @param array $shippingData The shipping data to display
     * @return string The rendered HTML
     */
    abstract public function renderView(array $shippingData): string;
}
