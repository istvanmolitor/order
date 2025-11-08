<?php
namespace Molitor\Order\Filament\Resources\OrderResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Molitor\Order\Filament\Resources\OrderResource;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    public function getBreadcrumb(): string
    {
        return __('order::common.list');
    }

    public function getTitle(): string
    {
        return __('order::order.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('order::order.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
