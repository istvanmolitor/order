<?php

namespace Molitor\Order\Filament\Resources\OrderStatusResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Molitor\Order\Filament\Resources\OrderStatusResource;

class ListOrderStatuses extends ListRecords
{
    protected static string $resource = OrderStatusResource::class;

    public function getBreadcrumb(): string
    {
        return __('order::common.list');
    }

    public function getTitle(): string
    {
        return __('order::order_status.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('order::order_status.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
