<?php

namespace Molitor\Order\Services;

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

    /**
     * Alias for compatibility with consumers expecting singular method name.
     */
    public function getOption(): array
    {
        return $this->getOptions();
    }
}
