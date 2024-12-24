<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Common\Constants\ProductConstant;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function intval;
use function str_replace;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?string $navigationIcon = 'hugeicons-sale-tag-02';

    protected static ?int $navigationSort = 70;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Product Information')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Product Name')
                                ->placeholder('Enter the product name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('product_code')
                                ->label('SKU')
                                ->placeholder('Enter the product code')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('description')
                                ->columnSpanFull(),
                        ])
                        ->columnSpanFull(),
                    Forms\Components\Section::make('Pricing')
                        ->columns(3)
                        ->schema([
                            Forms\Components\TextInput::make('cost_price')
                                ->required()
                                ->numeric()
                                ->placeholder('100000000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', 2)'))
                                ->stripCharacters('.')
                                ->prefix('Rp')
                                ->helperText('Harga pokok barang.'),
                            Forms\Components\TextInput::make('regular_price')
                                ->required()
                                ->numeric()
                                ->placeholder('100000000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', 2)'))
                                ->stripCharacters('.')
                                ->prefix('Rp')
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    if ($get('cost_price')) {
                                        $normalPrice = intval(str_replace('.', '', $get('cost_price')));
                                        $salePrice   = intval(str_replace('.', '', $state));
                                        if ($salePrice >= $normalPrice) {
                                            $set('regular_price', null);
                                        }
                                    }
                                })
                                ->reactive()
                                ->helperText('Regular price tidak boleh sama/lebih kecil dari Cost Price.'),
                            Forms\Components\TextInput::make('sale_price')
                                ->required()
                                ->numeric()
                                ->placeholder('100000000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', 2)'))
                                ->stripCharacters('.')
                                ->prefix('Rp')
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    if ($get('regular_price')) {
                                        $normalPrice = intval(str_replace('.', '', $get('regular_price')));
                                        $salePrice   = intval(str_replace('.', '', $state));
                                        if ($salePrice >= $normalPrice) {
                                            $set('sale_price', null);
                                        }
                                    }
                                })
                                ->reactive()
                                ->helperText('Sale price tidak boleh sama/lebih besar dari Regular Price.'),
                        ])
                        ->columnSpanFull(),
                    Forms\Components\Section::make('Stock')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('stock_quantity')
                                ->required()
                                ->default(0)
                                ->numeric(),
                            Forms\Components\Select::make('stock_unit')
                                ->required()
                                ->searchable()
                                ->default(ProductConstant::UNIT_PIECE)
                                ->options(ProductConstant::UNITS),
                        ])
                        ->columnSpanFull(),
                ])->columnSpan(2),
                Forms\Components\Section::make('Attributes')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status')
                            ->required(),
                    ])->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('regular_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_unit')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
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
