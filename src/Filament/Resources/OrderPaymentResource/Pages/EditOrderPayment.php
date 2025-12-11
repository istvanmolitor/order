<?php

namespace Molitor\Order\Filament\Resources\OrderPaymentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\Order\Filament\Resources\OrderPaymentResource;
use Molitor\Order\Repositories\OrderShippingPaymentRepositoryInterface;

class EditOrderPayment extends EditRecord
{
    protected static string $resource = OrderPaymentResource::class;

    protected function afterSave(): void
    {
        /** @var OrderShippingPaymentRepositoryInterface $repo */
        $repo = app(OrderShippingPaymentRepositoryInterface::class);
        $state = $this->form->getRawState();
        if (array_key_exists('shippings', $state)) {
            $repo->syncShippings((int) $this->record->id, (array) ($state['shippings'] ?? []));
        }
    }
}
