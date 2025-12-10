<?php

namespace Molitor\Order\Filament\Resources;

use Filament\Forms\Components\ColorPicker;
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
        return $schema->components([
            TextInput::make('code')
                ->label(__('order::order_shipping.form.code'))
                ->maxLength(50)
                ->unique(ignoreRecord: true),
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
                Forms\Components\RichEditor::make('description')
                    ->label(__('order::order_shipping.form.description'))
                    ->columnSpan(2),
            ])->columns(2),
            Select::make('payments')
                ->label(__('order::order_shipping.form.payments'))
                ->options($orderPaymentRepository->getOptions())
                ->multiple()
                ->searchable()
                ->preload()
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
                ColorColumn::make('color')->label('Szín')->sortable(),
                TextColumn::make('price')->label(__('order::common.price'))->numeric(2),
            ])
            ->actions([
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
            'index' => Pages\ListOrderShippings::route('/'),
            'create' => Pages\CreateOrderShipping::route('/create'),
            'edit' => Pages\EditOrderShipping::route('/{record}/edit'),
        ];
    }
}
