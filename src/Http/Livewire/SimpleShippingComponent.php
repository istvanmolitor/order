<?php

declare(strict_types=1);

namespace Molitor\Order\Http\Livewire;

use Livewire\Component;

class SimpleShippingComponent extends Component
{
    public array $shippingData = [];

    protected $rules = [
        'shippingData.contact' => 'required|string|max:255',
    ];

    protected $messages = [
        'shippingData.contact.required' => 'A kapcsolattartási információ kitöltése kötelező.',
        'shippingData.contact.max' => 'A kapcsolattartási információ maximum 255 karakter lehet.',
    ];

    public function mount(array $shippingData = []): void
    {
        $this->shippingData = $shippingData;
    }

    public function updatedShippingData(): void
    {
        $this->dispatch('shippingDataUpdated', $this->shippingData);
    }

    public function render()
    {
        return view('order::livewire.simple-shipping-component');
    }
}
