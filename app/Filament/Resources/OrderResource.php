<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Common\Constants\InvoiceConstant;
use App\Models\Common\Constants\OrderConstant;
use App\Models\Common\Constants\RecurringConstant;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

use function collect;
use function dd;
use function now;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?string $navigationIcon = 'hugeicons-shopping-cart-add-01';

    protected static ?int $navigationSort = 45;

    private array $products = [];

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
                    Forms\Components\Repeater::make('items')
                        ->label('Order Items')
                        ->columnSpan([
                            'md'  => 10,
                            '2xl' => 6
                        ])
                        ->columns(12)
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->required()
                                    ->live()
                                    ->searchable()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $quantity  = $get('quantity') ?? 1;
                                            $unitPrice = Number::format($product->price, locale: 'id') ?? null;
                                            $set('unit_price', $unitPrice);

                                            $totalPrice = Number::format($product->price * $quantity, locale: 'id')
                                                ??
                                                null;
                                            $set('total_price', $totalPrice);
                                        }
                                    })
                                    ->options(Product::all()->pluck('name', 'id')),
                                Forms\Components\TextInput::make('custom_label')
                                    ->hiddenLabel()
                                    ->placeholder('Custom Label')
                                    ->columnSpanFull(),
                            ])->columnSpan([
                                'md' => 5,
                            ]),

                            Forms\Components\TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->columnSpan([
                                    'md' => 1,
                                ])
                                ->extraInputAttributes(['class' => 'text-center'])
                                ->minValue(1)
                                ->default(1)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $productId = $get('product_id');
                                    if ($productId) {
                                        $price    = Product::find($productId)->price;
                                        $quantity = $state;
                                        $set('total_price', Number::format($price * $quantity, locale: 'id'));
                                    }
                                })
                                ->live()
                                ->integer(),
                            Forms\Components\TextInput::make('unit_price')
                                ->prefix('Rp')
                                ->placeholder('0.00')
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->disabled(),
                            Forms\Components\TextInput::make('total_price')
                                ->prefix('Rp')
                                ->placeholder(0.00)
                                ->extraInputAttributes(['class' => 'text-right'])
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->disabled(),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                    Forms\Components\Repeater::make('discounts')
                        ->columnSpan([
                            '2xl' => 2,
                            'md'  => 5
                        ])
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
                        ->columnSpan([
                            '2xl' => 2,
                            'md'  => 5
                        ])
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->hiddenLabel()
                                ->required()
                                ->options(Tax::all()->pluck('name', 'id'))
                                ->columnSpan([
                                    'md' => 5,
                                ]),
                        ])
                        ->reorderable(false)
                        ->reorderableWithDragAndDrop(false),
                ])
                    ->live()
                    // After adding a new row, we need to update the totals
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        self::updateTotals($get, $set);
                    })
                    ->columns(10)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Calculated Totals')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('discount_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('tax_amount')
                            ->disabled()
                            ->prefix('Rp')
                            ->extraInputAttributes(['class' => 'text-right'])
                            ->placeholder(0.00),
                        Forms\Components\TextInput::make('grand_amount')
                            ->disabled()
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
                        Forms\Components\Select::make('payment_type')
                            ->required()
                            ->searchable()
                            ->options(InvoiceConstant::PAYMENT_TYPES),

                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->searchable()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('payment_method_name', null))
                            ->options(InvoiceConstant::PAYMENT_METHODS),

                        Forms\Components\Select::make('payment_method_name')
                            ->required()
                            ->searchable()
                            ->options(function (Forms\Get $get):array {
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
        $selectedProducts = collect($get('items'))->filter(fn($item) => !empty($item['product_id']) && !empty($item['quantity']));

        // Retrieve prices for all selected products
        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id');

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        $discounts = collect($get('discounts'))->filter(fn($discount) => !empty($discount['discount_id']));
        $discount  = $discounts->reduce(function ($discount, $item) {
            return $discount + $item['discount_id'];
        }, 0);

        $taxes = collect($get('taxes'))->filter(fn($tax) => !empty($tax['tax_id']));
        $tax    = $taxes->reduce(function ($tax, $item) {
            return $tax + $item['tax_id'];
        }, 0);

        $grandAmount = $subtotal - $discount + $tax;
        // Update the state with the new values
        $set('total_amount', Number::format($subtotal, locale: 'id'));
        $set('discount_amount', Number::format($discount, locale: 'id'));
        $set('tax_amount', Number::format($tax, locale: 'id'));
        $set('grand_amount', Number::format($grandAmount, locale: 'id'));
    }
}
