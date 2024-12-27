<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Common\Constants\InvoiceConstant;
use App\Models\Common\Constants\OrderConstant;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function now;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?string $navigationIcon = 'hugeicons-shopping-cart-add-01';

    protected static ?int $navigationSort = 45;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->required()
                            ->options(Customer::all()->pluck('full_name', 'id'))
                            ->columnSpan(1),
                        Forms\Components\DatePicker::make('order_date')
                            ->default(now())
                            ->required()
                            ->columnSpan(1),
                    ]),
                Forms\Components\Group::make([
                    Forms\Components\Repeater::make('items')
                        ->columnSpan(6)
                        ->columns(12)
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->label('Product')
                                ->required()
                                ->options(Product::all()->pluck('name', 'id'))
                                ->columnSpan([
                                    'md' => 5,
                                ]),
                            Forms\Components\TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->columnSpan([
                                    'md' => 1,
                                ])
                                ->extraInputAttributes(['class' => 'text-center'])
                                ->default(1),
                            Forms\Components\TextInput::make('unit_price')
                                ->prefix('Rp')
                                ->placeholder('0.00')
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->readOnly(),
                            Forms\Components\TextInput::make('total_price')
                                ->readOnly()
                                ->numeric()
                                ->prefix('Rp')
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->placeholder(0.00),
                            Forms\Components\TextInput::make('custom_label')
                                ->hiddenLabel()
                                ->placeholder('Custom Label')
                                ->columnSpanFull(),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                    Forms\Components\Repeater::make('discounts')
                        ->columnSpan(2)
                        ->schema([
                            Forms\Components\Select::make('discount_id')
                                ->hiddenLabel()
                                ->required()
                                ->options(Discount::all()->pluck('name', 'id'))
                                ->columnSpan([
                                    'md' => 5,
                                ]),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                    Forms\Components\Repeater::make('taxes')
                        ->columnSpan(2)
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->label('Product')
                                ->required()
                                ->options(Product::all()->pluck('name', 'id'))
                                ->columnSpan([
                                    'md' => 5,
                                ]),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                ])
                    ->columns(10)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Summary')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('tax_amount')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('grand_amount')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00)
                    ])->columnSpan(1),

                Forms\Components\Section::make('Payment')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('payment_status')
                            ->required()
                            ->options(OrderConstant::STATUSES)
                            ->default(OrderConstant::STATUS_PENDING),
                        Forms\Components\Select::make('payment_method')
                            ->options(InvoiceConstant::PAYMENT_METHODS)
                            ->default(InvoiceConstant::PAYMENT_STATUS_DRAFT),
                    ])->columnSpan(1),

                Forms\Components\Section::make('Attachments')
                    ->description('Upload attachments for the order.')
                    ->schema([
                        Forms\Components\FileUpload::make('attachments')
                            ->hiddenLabel(),
                    ])->columnSpan(1),
                Forms\Components\Section::make('Notes')
                    ->description('Add notes for the order.')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->hiddenLabel(),
                    ])->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
