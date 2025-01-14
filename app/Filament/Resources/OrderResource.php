<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Common\Constants\DiscountConstant;
use App\Models\Common\Constants\InvoiceConstant;
use App\Models\Common\Constants\OrderConstant;
use App\Models\Common\Constants\RecurringConstant;
use App\Models\Common\Constants\TaxConstant;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

use function collect;
use function is_array;
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
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->default("ORD-" . now()->format('YmdHis'))
                            ->readOnly()
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\DatePicker::make('order_date')
                            ->default(now())
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->required()
                            ->searchable()
                            ->options(Customer::all()->pluck('full_name', 'id'))
                            ->columnSpan(2),
                    ]),

                Forms\Components\Group::make([
                    TableRepeater::make('orderItems')
                        ->label('Order Items')
                        ->headers([
                            Header::make('Product')
                                ->width('calc(60% - 100px)'),
                            Header::make('Qty')
                                ->align('center')
                                ->width('100px'),
                            Header::make('Unit Price')
                                ->width('20%'),
                            Header::make('Total Price')
                                ->width('20%'),
                        ])
                        ->columnSpan([
                            '2xl' => 8,
                            'md'  => 12
                        ])
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\Select::make('product_id')
                                    ->hiddenLabel()
                                    ->required()
                                    ->live()
                                    ->searchable()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ( ! $state || is_array($state)) {
                                            return;
                                        }

                                        $product = Product::find($state);
                                        if ($product) {
                                            $quantity  = $get('quantity') ?? 1;
                                            $unitPrice = Number::format($product->price, locale: 'id');
                                            $set('unit_price', $unitPrice);

                                            $totalPrice = Number::format($product->price * $quantity, locale: 'id');
                                            $set('total_price', $totalPrice);
                                        }
                                    })
                                    ->options(Product::all()->pluck('name', 'id')),
                                Forms\Components\TextInput::make('custom_label')
                                    ->hiddenLabel()
                                    ->placeholder('Custom Label'),
                            ]),

                            Forms\Components\TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->extraInputAttributes(['class' => 'text-center'])
                                ->minValue(1)
                                ->default(1)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    if ( ! $state || is_array($state)) {
                                        return;
                                    }

                                    $productId = $get('product_id');
                                    if ($productId) {
                                        $price      = Product::find($productId)->price;
                                        $quantity   = $state;
                                        $totalPrice = Number::format($price * $quantity, locale: 'id');
                                        $set('total_price', $totalPrice);
                                    }
                                })
                                ->live()
                                ->integer(),

                            Forms\Components\TextInput::make('unit_price')
                                ->prefix('Rp')
                                ->placeholder('0.00')
                                ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->disabled(),
                            Forms\Components\TextInput::make('total_price')
                                ->prefix('Rp')
                                ->placeholder(0.00)
                                ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->disabled(),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),

                    // Discounts
                    Forms\Components\Repeater::make('discounts')
                        ->columnSpan([
                            '2xl' => 2,
                            'md'  => 6
                        ])
                        ->simple(Forms\Components\Select::make('discount_id')
                            ->hiddenLabel()
                            ->options(Discount::all()->pluck('name', 'id'))
                        )
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),

                    // Taxes
                    Forms\Components\Repeater::make('taxes')
                        ->columnSpan([
                            '2xl' => 2,
                            'md'  => 6
                        ])
                        ->simple(Forms\Components\Select::make('tax_id')
                            ->hiddenLabel()
                            ->options(Tax::all()->pluck('name', 'id'))
                        )
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                ])
                ->live()
                // After adding a new row, we need to update the totals
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                    self::updateTotals($get, $set);
                })
                ->columns(12)
                ->columnSpanFull(),

                Forms\Components\Section::make('Calculated Totals')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('discount_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('tax_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('grand_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00)
                    ])->columnSpan(1),

                Forms\Components\Section::make('Payment')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('payment_status')
                            ->required()
                            ->options(InvoiceConstant::PAYMENT_STATUSES)
                            ->default(InvoiceConstant::PAYMENT_STATUS_UNPAID),
                        Forms\Components\Select::make('payment_type')
                            ->required()
                            ->searchable()
                            ->default(InvoiceConstant::PAYMENT_TYPE_CASH)
                            ->options(InvoiceConstant::PAYMENT_TYPES),

                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->searchable()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Forms\Set $set) => $set('payment_method_name', null))
                            ->default(InvoiceConstant::PAYMENT_METHOD_BANK_TRANSFER)
                            ->options(InvoiceConstant::PAYMENT_METHODS),

                        Forms\Components\Select::make('payment_method_name')
                            ->required()
                            ->searchable()
                            ->options(function (Forms\Get $get): array {
                                return match ($get('payment_method')) {
                                    InvoiceConstant::PAYMENT_METHOD_BANK_TRANSFER,
                                    InvoiceConstant::PAYMENT_METHOD_DIRECT_DEBIT,
                                    InvoiceConstant::PAYMENT_METHOD_VIRTUAL_ACCOUNT => InvoiceConstant::PAYMENT_BANKS,
                                    InvoiceConstant::PAYMENT_METHOD_CREDIT_CARD => InvoiceConstant::CREDIT_CARDS,
                                    InvoiceConstant::PAYMENT_METHOD_E_WALLET => InvoiceConstant::E_WALLETS,
                                    InvoiceConstant::PAYMENT_METHOD_RETAIL => InvoiceConstant::RETAILS,
                                    default => [],
                                };
                            }),

                        Forms\Components\Select::make('recurring')
                            ->searchable()
                            ->options(RecurringConstant::RECURRING_TYPES)
                            ->default(RecurringConstant::RECURRING_TYPE_ONCE),
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
                            ->rows(10)
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
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => OrderConstant::STATUSES[$state] ?? $state)
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Discount')
                    ->money('IDR', locale: 'id')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Tax')
                    ->money('IDR', locale: 'id')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_amount')
                    ->label('Grand Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->formatStateUsing(fn($state) => OrderConstant::STATUSES[$state] ?? $state)
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(fn($state) => InvoiceConstant::PAYMENT_METHODS[$state] ?? $state)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make()
                    ->slideOver(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->iconButton(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Invoice Details')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('order_number')
                            ->label('Invoice Number'),
                        Infolists\Components\TextEntry::make('id')
                            ->label('Order ID'),
                        Infolists\Components\TextEntry::make('customer.full_name')
                            ->label('Customer ID'),
                        Infolists\Components\TextEntry::make('issue_date')
                            ->date(),
                        Infolists\Components\TextEntry::make('due_date')
                            ->date(),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'unpaid' => 'danger',
                                default => 'gray',
                            }),
                    ]),

                Infolists\Components\RepeatableEntry::make('orderItems')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                            ->formatStateUsing(function ($state, $record) {
                                return $state . ' (x' . $record->quantity . ')';
                            })
                            ->label('Product'),
                        Infolists\Components\TextEntry::make('unit_price')
                            ->money('IDR', locale: 'id')
                            ->label('Unit Price'),
                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Subtotal')
                            ->money('IDR', locale: 'id'),
                    ])
                    ->columnSpanFull(),


                Infolists\Components\Section::make('Financial Details')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('total_amount')
                            ->label('Subtotal')
                            ->money('IDR', locale: 'id'),
                        Infolists\Components\TextEntry::make('discount_amount')
                            ->label('Discount')
                            ->money('IDR', locale: 'id'),
                        Infolists\Components\TextEntry::make('tax_amount')
                            ->label('Tax')
                            ->money('IDR', locale: 'id'),
                        Infolists\Components\TextEntry::make('grand_amount')
                            ->label('Total')
                            ->money('IDR', locale: 'id')
                            ->weight('bold'),
                    ]),

                Infolists\Components\Section::make('Payment Information')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'unpaid' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('payment_date')
                            ->date(),
                    ]),

                Infolists\Components\Section::make('Additional Information')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('createdBy.name')
                            ->label('Created By'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function updateTotals(Forms\Get $get, Forms\Set $set): void
    {
        // Retrieve all selected products and remove empty rows
        $selectedProducts = collect($get('orderItems'))
            ->values() // Mengatur ulang key menjadi numerik
            ->filter(fn($item) => ! empty($item['product_id']) && ! empty($item['quantity']));

        // Retrieve prices for all selected products
        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id');

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        $discounts = collect($get('discounts'))->filter(fn($discount) => ! empty($discount['discount_id']));
        $discount  = $discounts->reduce(function ($discount, $item) use ($subtotal) {
            $discountItem = Discount::find($item['discount_id']);

            if ($discountItem->type === DiscountConstant::TYPE_PERCENTAGE) {
                return $discount + ($subtotal * $discountItem->value / 100);
            }

            return $discount + $discountItem->value;
        }, 0);

        $taxes = collect($get('taxes'))->filter(fn($tax) => ! empty($tax['tax_id']));
        $tax   = $taxes->reduce(function ($tax, $item) use ($subtotal, $discount) {
            $taxItem = Tax::find($item['tax_id']);

            if ($taxItem->type === TaxConstant::TYPE_PERCENTAGE) {
                if ($subtotal - $discount <= 0) {
                    return $tax + ($subtotal * $taxItem->rate / 100);
                }

                return $tax + (($subtotal - $discount) * $taxItem->rate / 100);
            }

            return $tax + $taxItem->rate;
        }, 0);

        $grandAmount = $subtotal - $discount + $tax;

        // Update the state with the new values
        $set('total_amount', Number::format($subtotal, locale: 'id'));
        $set('discount_amount', Number::format($discount, locale: 'id'));
        $set('tax_amount', Number::format($tax, locale: 'id'));
        $set('grand_amount', Number::format($grandAmount, locale: 'id'));
    }
}
