<?php
namespace Molitor\Order\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\Order\Filament\Resources\OrderResource;
use Molitor\Address\Repositories\AddressRepositoryInterface;
use Molitor\Address\Models\Address;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        if (method_exists($record, 'invoiceAddress') && $record->invoiceAddress) {
            $inv = $record->invoiceAddress;
            $data['invoice_address'] = [
                'name' => $inv->name,
                'country_id' => $inv->country_id,
                'zip_code' => $inv->zip_code,
                'city' => $inv->city,
                'address' => $inv->address,
            ];
        }
        if (method_exists($record, 'shippingAddress') && $record->shippingAddress) {
            $ship = $record->shippingAddress;
            $data['shipping_address'] = [
                'name' => $ship->name,
                'country_id' => $ship->country_id,
                'zip_code' => $ship->zip_code,
                'city' => $ship->city,
                'address' => $ship->address,
            ];
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var AddressRepositoryInterface $addressRepository */
        $addressRepository = app(AddressRepositoryInterface::class);
        $record = $this->getRecord();

        // Invoice address (required FK)
        $invoice = $record->invoiceAddress ?: new Address();
        if (isset($data['invoice_address']) && is_array($data['invoice_address'])) {
            $addressRepository->saveAddress($invoice, $data['invoice_address']);
            $data['invoice_address_id'] = $invoice->id;
            unset($data['invoice_address']);
        }

        // Shipping address (nullable FK)
        $shipping = $record->shippingAddress ?: new Address();
        if (isset($data['shipping_address']) && is_array($data['shipping_address'])) {
            $addressRepository->saveAddress($shipping, $data['shipping_address']);
            $data['shipping_address_id'] = $shipping->id;
            unset($data['shipping_address']);
        }

        return $data;
    }
}
