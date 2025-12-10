<?php

namespace Molitor\Order\Filament\Resources;

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
use Molitor\Order\Filament\Resources\OrderPaymentResource\Pages;
use Molitor\Order\Models\OrderPayment;

class OrderPaymentResource extends Resource
{
    protected static ?string $model = OrderPayment::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-credit-card';

    public static function getNavigationGroup(): string
    {
        return __('order::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('order::order_payment.title');
    }

    public static function canAccess(): bool
    {
        return Gate::allows('acl', 'order');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('code')
                ->label(__('order::order_payment.form.code'))
                ->maxLength(50)
                ->unique(ignoreRecord: true),
            Forms\Components\ColorPicker::make('color')
                ->label('Szín')
                ->nullable(),
            TranslatableFields::schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('order::order_payment.form.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label(__('order::order_payment.form.description'))
                    ->columnSpan(2),
            ])->columns(2),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label(__('order::order_payment.table.code'))->searchable()->sortable(),
                TextColumn::make('translation.name')->label(__('order::order_payment.table.name'))->searchable()->sortable(),
                ColorColumn::make('color')->label('Szín')->sortable(),
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
            'index' => Pages\ListOrderPayments::route('/'),
            'create' => Pages\CreateOrderPayment::route('/create'),
            'edit' => Pages\EditOrderPayment::route('/{record}/edit'),
        ];
    }
}
