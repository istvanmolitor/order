<?php

namespace Molitor\Order\Services;

use Molitor\Order\Models\OrderShipping;

class ShippingHandler
{
    private array $shippingTypes = [];

    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {
        $this
            ->addShippingType(new AddressShippingType())
            ->addShippingType(new SimpleShippingType());
    }

    public function addShippingType(ShippingType $shippingType): static
    {
        $this->shippingTypes[$shippingType->getName()] = $shippingType;
        return $this;
    }

    public function getShippingType(string $name): ShippingType|null
    {
        return $this->shippingTypes[$name] ?? null;
    }

    public function getOptions(): array
    {
        $options = [];
        /** @var ShippingType $shippingType */
        foreach ($this->shippingTypes as $shippingType) {
            if( $shippingType->isEnabled()) {
                $options[$shippingType->getName()] = $shippingType->getLabel();
            }
        }
        return $options;
    }

    public function getOption(): array
    {
        return $this->getOptions();
    }

    public function getDefaultValues(string $shippingTypeName): array
    {
        $shippingType = $this->getShippingType($shippingTypeName);
        if(!$shippingType) {
           return [];
        }
        return $shippingType->getDefaultValues();
    }

    public function renderForm(OrderShipping $orderShipping, array $params = []): string
    {
        $shippingType = $this->getShippingType($orderShipping->type);
        if(!$shippingType) {
            return '';
        }

        $formTemplate = $shippingType->getFormTemplate();

        return view($formTemplate, $params)->render();
    }
}
