<?php

namespace Molitor\Order\Filament\Resources\OrderShippingResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Order\Filament\Resources\OrderShippingResource;
use Molitor\Order\Repositories\OrderShippingPaymentRepositoryInterface;

class CreateOrderShipping extends CreateRecord
{
    protected static string $resource = OrderShippingResource::class;

    protected function afterCreate(): void
    {
        /** @var OrderShippingPaymentRepositoryInterface $repo */
        $repo = app(OrderShippingPaymentRepositoryInterface::class);
        $state = $this->form->getRawState();
        $repo->syncPayments((int) $this->record->id, (array) ($state['payments'] ?? []));
    }
}
