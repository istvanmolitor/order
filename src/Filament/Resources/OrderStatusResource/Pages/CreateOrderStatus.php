<?php

namespace Molitor\Order\Filament\Resources\OrderStatusResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Order\Filament\Resources\OrderStatusResource;

class CreateOrderStatus extends CreateRecord
{
    protected static string $resource = OrderStatusResource::class;
}
