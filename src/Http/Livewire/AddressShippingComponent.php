<?php

declare(strict_types=1);

namespace Molitor\Order\Http\Livewire;

use Livewire\Component;
use Molitor\Address\Repositories\CountryRepositoryInterface;

class AddressShippingComponent extends Component
{
    public array $shippingData = [];

    protected $rules = [
        'shippingData.address.name' => 'required|string|max:255',
        'shippingData.address.country_id' => 'required|integer|exists:countries,id',
        'shippingData.address.zip_code' => 'required|string|max:10',
        'shippingData.address.city' => 'required|string|max:255',
        'shippingData.address.address' => 'required|string|max:255',
    ];

    protected $messages = [
        'shippingData.address.name.required' => 'A név mező kitöltése kötelező.',
        'shippingData.address.name.max' => 'A név maximum 255 karakter lehet.',
        'shippingData.address.country_id.required' => 'Az ország kiválasztása kötelező.',
        'shippingData.address.country_id.exists' => 'A kiválasztott ország nem érvényes.',
        'shippingData.address.zip_code.required' => 'Az irányítószám kitöltése kötelező.',
        'shippingData.address.zip_code.max' => 'Az irányítószám maximum 10 karakter lehet.',
        'shippingData.address.city.required' => 'A város kitöltése kötelező.',
        'shippingData.address.city.max' => 'A város maximum 255 karakter lehet.',
        'shippingData.address.address.required' => 'A cím kitöltése kötelező.',
        'shippingData.address.address.max' => 'A cím maximum 255 karakter lehet.',
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
        $countryRepository = app(CountryRepositoryInterface::class);

        return view('order::livewire.address-shipping-component', [
            'countries' => $countryRepository->getAll(),
            'defaultCountryId' => $countryRepository->getDefaultId(),
        ]);
    }
}
