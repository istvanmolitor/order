<?php

namespace Molitor\Order\Filament\Resources\OrderStatusResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\Order\Filament\Resources\OrderStatusResource;

class EditOrderStatus extends EditRecord
{
    protected static string $resource = OrderStatusResource::class;
}
