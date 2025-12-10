<?php

namespace Molitor\Order\Filament\Resources\OrderPaymentResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Molitor\Order\Filament\Resources\OrderPaymentResource;

class ListOrderPayments extends ListRecords
{
    protected static string $resource = OrderPaymentResource::class;

    public function getBreadcrumb(): string
    {
        return __('order::common.list');
    }

    public function getTitle(): string
    {
        return __('order::order_payment.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('order::order_payment.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
