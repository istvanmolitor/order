<?php

namespace Molitor\Order\Filament\Resources;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Molitor\Language\Filament\Components\TranslatableFields;
use Molitor\Order\Filament\Resources\OrderShippingResource\Pages;
use Molitor\Order\Models\OrderShipping;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;
use Molitor\Currency\Repositories\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Molitor\Order\Services\ShippingHandler;

class OrderShippingResource extends Resource
{
    protected static ?string $model = OrderShipping::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-truck';

    public static function getNavigationGroup(): string
    {
        return __('order::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('order::order_shipping.title');
    }

    public static function canAccess(): bool
    {
        return Gate::allows('acl', 'order');
    }

    public static function form(Schema $schema): Schema
    {
        /** @var OrderPaymentRepositoryInterface $orderPaymentRepository */
        $orderPaymentRepository = app(OrderPaymentRepositoryInterface::class);
        /** @var CurrencyRepositoryInterface $currencyRepository */
        $currencyRepository = app(CurrencyRepositoryInterface::class);
        /** @var ShippingHandler $shippingService */
        $shippingService = app(ShippingHandler::class);

        return $schema->components([
            TextInput::make('code')
                ->label(__('order::order_shipping.form.code'))
                ->maxLength(50)
                ->unique(ignoreRecord: true),
            Select::make('type')
                ->label('Típus')
                ->options($shippingService->getOptions())
                ->searchable()
                ->required(fn (?Model $record) => $record === null)
                ->disabled(fn (?Model $record) => $record !== null),
            ColorPicker::make('color')
                ->label('Szín')
                ->nullable(),
            TextInput::make('price')
                ->label(__('order::common.price'))
                ->suffix($currencyRepository->getDefault()->code)
                ->numeric()
                ->minValue(0)
                ->maxValue(99999999999),
            TranslatableFields::schema([
                TextInput::make('name')
                    ->label(__('order::order_shipping.form.name'))
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->label(__('order::order_shipping.form.description'))
                    ->columnSpan(2),
            ])->columns(2),
            Select::make('payments')
                ->label(__('order::order_shipping.form.payments'))
                ->options($orderPaymentRepository->getOptions())
                ->searchable()
                ->preload()
                ->multiple()
                ->default(fn (?Model $record) => $record?->payments?->pluck('id')->values()->all() ?? [])
                ->afterStateHydrated(function (Select $component, ?Model $record): void {
                    if ($record) {
                        $component->state($record->payments?->pluck('id')->values()->all() ?? []);
                    }
                })
                ->dehydrated(false)
                ->columnSpanFull(),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label(__('order::order_shipping.table.code'))->searchable()->sortable(),
                TextColumn::make('translation.name')->label(__('order::order_shipping.table.name'))->searchable()->sortable(),
                TextColumn::make('type')->label('Típus')->sortable(),
                ColorColumn::make('color')->label('Szín')->sortable(),
                TextColumn::make('price')
                    ->label(__('order::common.price'))
                    ->formatStateUsing(fn (OrderShipping $record) => (string) $record->getPrice()),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->disabled(fn (OrderShipping $record): bool => $record->isInUse())
                    ->tooltip(fn (OrderShipping $record): ?string => $record->isInUse() ? __('Ezt a szállítási módot nem lehet törölni, mert meglévő rendelések használják.') : null),
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
            'index' => Pages\ListOrderShippings::route('/'),
            'create' => Pages\CreateOrderShipping::route('/create'),
            'edit' => Pages\EditOrderShipping::route('/{record}/edit'),
        ];
    }
}
