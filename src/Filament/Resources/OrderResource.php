<?php

namespace Molitor\Order\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Gate;
use Molitor\Address\Filament\Components\Address;
use Molitor\Customer\Repositories\CustomerRepositoryInterface;
use Molitor\Order\Filament\Resources\OrderResource\Pages;
use Molitor\Order\Models\Order;
use Molitor\Currency\Models\Currency;
use Molitor\Order\Repositories\OrderStatusRepositoryInterface;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;
use Molitor\Order\Repositories\OrderShippingRepositoryInterface;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-receipt-refund';

    public static function getNavigationGroup(): string
    {
        return __('order::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('order::order.title');
    }

    public static function canAccess(): bool
    {
        return Gate::allows('acl', 'order');
    }

    public static function form(Schema $schema): Schema
    {
        /** @var CustomerRepositoryInterface $customerRepository */
        $customerRepository = app(CustomerRepositoryInterface::class);
        /** @var OrderStatusRepositoryInterface $orderStatusRepository */
        $orderStatusRepository = app(OrderStatusRepositoryInterface::class);
        /** @var OrderPaymentRepositoryInterface $orderPaymentRepository */
        $orderPaymentRepository = app(OrderPaymentRepositoryInterface::class);
        /** @var OrderShippingRepositoryInterface $orderShippingRepository */
        $orderShippingRepository = app(OrderShippingRepositoryInterface::class);

        return $schema->components([
            Tabs::make('order::common.general')->tabs([
                Tabs\Tab::make('general')->label(__('order::common.general'))->schema([
                    Toggle::make('is_closed')
                        ->label(__('order::common.is_closed'))
                        ->default(true),
                    Grid::make(3)->schema([
                        TextInput::make('code')
                            ->label(__('order::common.code'))
                            ->maxLength(20),
                        Select::make('customer_id')
                            ->label(__('order::common.customer'))
                            ->relationship('customer', 'name')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) use ($customerRepository) {
                                if (empty($state)) {
                                    return;
                                }
                                $customer = $customerRepository->getById($state);
                                if ($customer && $customer->currency_id) {
                                    $set('currency_id', $customer->currency_id);
                                }
                            }),
                        Select::make('currency_id')
                            ->label(__('order::common.currency'))
                            ->options(Currency::query()->pluck('code', 'id')),
                        Select::make('order_status_id')
                            ->label(__('order::common.order_status'))
                            ->options($orderStatusRepository->getOptions())
                            ->required()
                            ->searchable(),
                        Select::make('order_payment_id')
                            ->label(__('order::common.order_payment'))
                            ->options($orderPaymentRepository->getOptions())
                            ->searchable(),
                        Select::make('order_shipping_id')
                            ->label(__('order::common.order_shipping'))
                            ->options($orderShippingRepository->getOptions())
                            ->searchable(),
                        TextInput::make('phone')
                            ->label(__('order::common.phone'))
                            ->maxLength(64),
                        TextInput::make('referer')
                            ->label(__('order::common.referer'))
                            ->maxLength(255),
                        TextInput::make('invoice')
                            ->label(__('order::common.invoice'))
                            ->maxLength(255),
                    ]),
                    Textarea::make('comment')->label(__('order::common.comment'))->columnSpanFull(),
                    Textarea::make('internal_comment')->label(__('order::common.internal_comment'))->columnSpanFull(),
                ]),
                Tabs\Tab::make('items')->label(__('order::common.addresses'))->schema([
                    Address::make('invoice_address', __('order::common.invoice_address')),
                    Address::make('shipping_address', __('order::common.shipping_address')),
                ]),
                Tabs\Tab::make('payments')->label(__('order::common.items'))->schema([
                    Repeater::make('orderItems')
                        ->relationship()
                        ->schema([
                            Grid::make(6)->schema([
                                Select::make('product_id')
                                    ->label(__('order::common.product'))
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn($record) => (string) $record)
                                    ->relationship('product', 'id')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('sku')->label(__('order::common.sku'))->maxLength(255)->columnSpan(2),
                                TextInput::make('name')->label(__('order::common.name'))->maxLength(255)->columnSpan(2),
                                TextInput::make('quantity')->label(__('order::common.quantity'))->numeric()->required(),
                                TextInput::make('price')->label(__('order::common.price'))->numeric(),
                            ]),
                            TextInput::make('comment')->label(__('order::common.comment'))->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->defaultItems(1)
                        ->addActionLabel(__('order::common.add_item')),
                    ]),
            ]),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        /** @var OrderStatusRepositoryInterface $orderStatusRepository */
        $orderStatusRepository = app(OrderStatusRepositoryInterface::class);

        return $table
            ->columns([
                TextColumn::make('code')->label(__('order::common.code'))->searchable()->sortable(),
                TextColumn::make('customer.name')->label(__('order::common.customer'))->sortable(),
                TextColumn::make('orderStatus')->label(__('order::common.status')),
            ])
            ->filters([
                SelectFilter::make('order_status_id')
                    ->label(__('order::common.order_status'))
                    ->options($orderStatusRepository->getOptions())
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
