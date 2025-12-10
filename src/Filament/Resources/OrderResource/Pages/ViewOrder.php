<?php

namespace Molitor\Order\Filament\Resources\OrderResource\Pages;

use Filament\Actions\EditAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Molitor\Order\Filament\Resources\OrderResource;
use Molitor\Customer\Filament\Resources\CustomerResource;
use Molitor\Product\Filament\Resources\ProductResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label(__('order::common.edit')),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('order::common.general'))
                    ->schema([
                        IconEntry::make('is_closed')
                            ->label(__('order::common.is_closed'))
                            ->boolean(),
                        TextEntry::make('code')
                            ->label(__('order::common.code')),
                        TextEntry::make('customer.name')
                            ->label(__('order::common.customer'))
                            ->url(fn ($record) => $record->customer ? CustomerResource::getUrl('edit', ['record' => $record->customer]) : null)
                            ->openUrlInNewTab(),
                        TextEntry::make('orderStatus')
                            ->label(__('order::common.order_status'))
                            ->state(function ($record) {
                                $status = $record->orderStatus;
                                if (!$status) return null;
                                $color = $status->color;
                                $name = e($status->name ?? '');
                                $dot = $color
                                    ? "<span style=\"display:inline-block;width:0.75rem;height:0.75rem;border-radius:9999px;background-color: {$color};margin-right:0.375rem;vertical-align:middle;border:1px solid rgba(0,0,0,0.1)\"></span>"
                                    : '';
                                return $dot . $name;
                            })
                            ->html(),
                        TextEntry::make('orderPayment')
                            ->label(__('order::common.order_payment'))
                            ->state(function ($record) {
                                $payment = $record->orderPayment;
                                if (!$payment) return null;
                                $color = $payment->color;
                                $name = e($payment->name ?? '');
                                $dot = $color
                                    ? "<span style=\"display:inline-block;width:0.75rem;height:0.75rem;border-radius:9999px;background-color: {$color};margin-right:0.375rem;vertical-align:middle;border:1px solid rgba(0,0,0,0.1)\"></span>"
                                    : '';
                                return $dot . $name;
                            })
                            ->html(),
                        TextEntry::make('orderShipping')
                            ->label(__('order::common.order_shipping'))
                            ->state(function ($record) {
                                $shipping = $record->orderShipping;
                                if (!$shipping) return null;
                                $color = $shipping->color;
                                $name = e($shipping->name ?? '');
                                $dot = $color
                                    ? "<span style=\"display:inline-block;width:0.75rem;height:0.75rem;border-radius:9999px;background-color: {$color};margin-right:0.375rem;vertical-align:middle;border:1px solid rgba(0,0,0,0.1)\"></span>"
                                    : '';
                                return $dot . $name;
                            })
                            ->html(),
                    ])
                    ->columns(2),

                Fieldset::make(__('order::common.addresses'))
                    ->schema([
                        TextEntry::make('invoiceAddress.name')
                            ->label(__('order::common.invoice_address')),
                        TextEntry::make('invoiceAddress.zip_code')
                            ->label(__('order::common.zip_code')),
                        TextEntry::make('invoiceAddress.city')
                            ->label(__('order::common.city')),
                        TextEntry::make('invoiceAddress.address')
                            ->label(__('order::common.address')),

                        TextEntry::make('shippingAddress.name')
                            ->label(__('order::common.shipping_address')),
                        TextEntry::make('shippingAddress.zip_code')
                            ->label(__('order::common.zip_code')),
                        TextEntry::make('shippingAddress.city')
                            ->label(__('order::common.city')),
                        TextEntry::make('shippingAddress.address')
                            ->label(__('order::common.address')),
                    ])
                    ->columns(4),

                Fieldset::make(__('order::common.items'))
                    ->schema([
                        RepeatableEntry::make('orderItems')
                            ->label('')
                            ->schema([
                                TextEntry::make('product')
                                    ->label(__('order::common.product'))
                                    ->state(fn ($record) => (string) $record->product)
                                    ->url(fn ($record) => $record->product ? ProductResource::getUrl('edit', ['record' => $record->product]) : null)
                                    ->openUrlInNewTab()
                                    ->columnSpan(2),
                                TextEntry::make('quantity')
                                    ->label(__('order::common.quantity'))
                                    ->columnSpan(1),
                                TextEntry::make('price')
                                    ->label(__('order::common.price'))
                                    ->columnSpan(1),
                                TextEntry::make('comment')
                                    ->label(__('order::common.comment'))
                                    ->visible(fn ($record) => !empty($record->comment))
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->columnSpanFull(),
                    ]),

                Fieldset::make(__('order::common.comment'))
                    ->schema([
                        TextEntry::make('comment')
                            ->label(__('order::common.comment'))
                            ->placeholder(__('order::common.no_comment'))
                            ->columnSpanFull(),
                        TextEntry::make('internal_comment')
                            ->label(__('order::common.internal_comment'))
                            ->placeholder(__('order::common.no_comment'))
                            ->columnSpanFull(),
                    ]),

                Fieldset::make(__('order::common.timestamps'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('order::common.created_at'))
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('order::common.updated_at'))
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
