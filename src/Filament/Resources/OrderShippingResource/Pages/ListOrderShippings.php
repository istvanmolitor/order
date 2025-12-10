<?php

namespace Molitor\Order\Filament\Resources\OrderShippingResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Molitor\Order\Filament\Resources\OrderShippingResource;

class ListOrderShippings extends ListRecords
{
    protected static string $resource = OrderShippingResource::class;

    public function getBreadcrumb(): string
    {
        return __('order::common.list');
    }

    public function getTitle(): string
    {
        return __('order::order_shipping.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('order::order_shipping.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
