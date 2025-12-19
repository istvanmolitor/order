<?php

namespace Molitor\Order\Services;

use Illuminate\Support\Facades\Validator;
use Molitor\Address\Filament\Components\Address;
use Molitor\Address\Repositories\CountryRepositoryInterface;

class AddressShippingType extends ShippingType
{

    public function getName(): string
    {
        return 'address';
    }

    public function getLabel(): string
    {
        return __('order::common.address');
    }

    public function getForm(): array
    {
        return [
            Address::make('address', __('order::common.address'))
        ];
    }

    public function prepare(array $data): array
    {
        return $data ?? [];
    }

    public function validationRules(array $data): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'zip_code' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function getDefaultValues(): array
    {
        return [
            'name' => '',
            'country_id' => app(CountryRepositoryInterface::class)->getDefaultId(),
            'zip_code' => '',
            'city' => '',
            'address' => '',
        ];
    }

    public function getFormTemplate(): string
    {
        return 'order::shipping.address';
    }

    public function getFormTemplateData(): array
    {
        /** @var CountryRepositoryInterface $countryRepository */
        $countryRepository = app(CountryRepositoryInterface::class);
        return [
            'countries' => $countryRepository->getOptions(),
            'defaultCountryId' => $countryRepository->getDefaultId(),
        ];
    }

    public function renderView(array $shippingData): string
    {
        $countryName = null;
        if (isset($shippingData['country_id'])) {
            /** @var CountryRepositoryInterface $countryRepository */
            $countryRepository = app(CountryRepositoryInterface::class);
            $country = $countryRepository->getById($shippingData['country_id']);
            $countryName = $country->name ?? null;
        }

        return view('order::shipping.address-display', array_merge($shippingData, [
            'countryName' => $countryName,
        ]))->render();
    }
}
