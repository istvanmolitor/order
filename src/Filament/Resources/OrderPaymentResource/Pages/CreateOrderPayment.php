<?php

namespace Molitor\Order\Filament\Resources\OrderPaymentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Order\Filament\Resources\OrderPaymentResource;
use Molitor\Order\Repositories\OrderShippingPaymentRepositoryInterface;

class CreateOrderPayment extends CreateRecord
{
    protected static string $resource = OrderPaymentResource::class;

    protected function afterCreate(): void
    {
        /** @var OrderShippingPaymentRepositoryInterface $repo */
        $repo = app(OrderShippingPaymentRepositoryInterface::class);
        $state = $this->form->getRawState();
        $repo->syncShippings((int) $this->record->id, (array) ($state['shippings'] ?? []));
    }
}
