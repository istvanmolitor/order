<?php
namespace Molitor\Order\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Order\Filament\Resources\OrderResource;
use Molitor\Address\Repositories\AddressRepositoryInterface;
use Molitor\Address\Models\Address;
use Molitor\Order\Models\OrderShipping;
use Molitor\Order\Services\ShippingHandler;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var AddressRepositoryInterface $addressRepository */
        $addressRepository = app(AddressRepositoryInterface::class);

        if (isset($data['invoice_address']) && is_array($data['invoice_address'])) {
            $invoice = new Address();
            $addressRepository->saveAddress($invoice, $data['invoice_address']);
            $data['invoice_address_id'] = $invoice->id;
            unset($data['invoice_address']);
        } else {
            $data['invoice_address_id'] = $addressRepository->createEmptyId();
        }

        if (isset($data['shipping_address']) && is_array($data['shipping_address'])) {
            $shipping = new Address();
            $addressRepository->saveAddress($shipping, $data['shipping_address']);
            $data['shipping_address_id'] = $shipping->id;
            unset($data['shipping_address']);
        }

        // Validate and normalize shipping-specific data
        if (!empty($data['order_shipping_id'])) {
            $shipping = OrderShipping::find($data['order_shipping_id']);
            if ($shipping) {
                /** @var ShippingHandler $handler */
                $handler = app(ShippingHandler::class);
                $type = $handler->getShippingType($shipping->type);
                if ($type) {
                    $payload = $data['shipping_data'] ?? [];
                    $data['shipping_data'] = $type->prepare(is_array($payload) ? $payload : []);
                }
            }
        } else {
            $data['shipping_data'] = null;
        }

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('Sikeres mentés');
    }
}
