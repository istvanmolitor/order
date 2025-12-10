<?php

namespace Molitor\Order\Filament\Resources\OrderPaymentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Order\Filament\Resources\OrderPaymentResource;

class CreateOrderPayment extends CreateRecord
{
    protected static string $resource = OrderPaymentResource::class;
}
