<?php

namespace Molitor\Order\Filament\Resources\OrderShippingResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\Order\Filament\Resources\OrderShippingResource;
use Molitor\Order\Repositories\OrderShippingPaymentRepositoryInterface;

class EditOrderShipping extends EditRecord
{
    protected static string $resource = OrderShippingResource::class;

    protected function afterSave(): void
    {
        /** @var OrderShippingPaymentRepositoryInterface $repo */
        $repo = app(OrderShippingPaymentRepositoryInterface::class);
        $state = $this->form->getState();
        $repo->syncPayments((int) $this->record->id, (array) ($state['payments'] ?? []));
    }
}
