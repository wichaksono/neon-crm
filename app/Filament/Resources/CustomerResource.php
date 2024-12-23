<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Common\Constants\CustomerConstant;
use App\Models\Company;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Contacts';

    protected static ?string $navigationIcon = 'hugeicons-user-account';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->placeholder('John Doe')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nick_name')
                            ->required()
                            ->placeholder('john_doe')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->placeholder('john.doe@gmail.com')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->placeholder('123-456-7890')
                            ->maxLength(255)
                            ->default(null),
                    ])->columns()->columnSpan(2),
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->avatar()
                        ->imageEditor()
                        ->circleCropper()
                        ->extraAttributes(['class' => 'items-center justify-center w-24 h-24'])
                    ->columnSpan(1),
                ])->columns(3)->columnSpanFull(),

                Forms\Components\TextInput::make('website')
                    ->maxLength(255)
                    ->placeholder('https://www.example.com')
                    ->default(null),

                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->searchable()
                    ->placeholder('No Company')
                    ->options(
                        Company::all()->where('type', CustomerConstant::TYPE_COMPANY)->pluck('full_name', 'id')
                    )
                    ->helperText('Select the company this customer is associated with.'),


                Forms\Components\TextInput::make('country')
                    ->placeholder('Indonesia')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('state')
                    ->placeholder('DKI Jakarta')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->placeholder('Jakarta')
                    ->default(null),

                Forms\Components\TextInput::make('postal_code')
                    ->placeholder('12345')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Textarea::make('address')
                    ->placeholder('Jl. Jend. Sudirman No. 1')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl('https://placehold.co/150')
                    ->label('Avatar'),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nick_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)
                    ->icon('hugeicons-copy-02')
                    ->iconPosition(IconPosition::After)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->copyable()
                    ->copyMessage('Phone copied')
                    ->copyMessageDuration(1500)
                    ->icon('hugeicons-copy-02')
                    ->iconPosition(IconPosition::After)
                    ->searchable(),

//                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('address')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('city')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('state')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('postal_code')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('country')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
//                ]),

//                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('company_id')
                    ->label('Company')
                    ->numeric()
                    ->sortable(),
//                Tables\Columns\TextColumn::make('industry')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('website')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('person_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('label')
//                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', CustomerConstant::TYPE_PERSON)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
