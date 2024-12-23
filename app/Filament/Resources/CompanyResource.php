<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Common\Constants\CustomerConstant;
use App\Models\Company;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = 'Contacts';

    protected static ?string $navigationIcon = 'hugeicons-building-03';

    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Company Name')
                            ->placeholder('PT Mahardika Digitaloka Wichaksana')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nick_name')
                            ->label('Short Name')
                            ->placeholder('Mahardika Digital')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->placeholder('contact@mhdigital.com')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->placeholder('081234567890')
                            ->tel()
                            ->maxLength(255)
                            ->default(null),
                    ])->columns()->columnSpan(2),
                    Forms\Components\FileUpload::make('avatar')
                        ->hiddenLabel()
                        ->image()
                        ->avatar()
                        ->imageEditor()
                        ->circleCropper()
                        ->extraAttributes(['class' => 'items-center justify-center'])
                        ->columnSpan(1)
                ])->columns(3)->columnSpanFull(),

                Forms\Components\Select::make('industry')
                    ->options(
                        collect(CustomerConstant::INDUSTRIES)
                            ->mapWithKeys(fn($industry) => [$industry => $industry])
                            ->toArray()
                    )
                    ->searchable(),
                Forms\Components\TextInput::make('website')
                    ->placeholder('https://www.mhdigital.com')
                    ->default(null),

                Forms\Components\TextInput::make('country')
                    ->label('Country')
                    ->placeholder('Indonesia')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('state')
                    ->label('State')
                    ->placeholder('East Java')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->placeholder('Malang')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->placeholder('Jl. Raya Kedungkandang No. 123')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('postal_code')
                    ->label('Postal Code')
                    ->placeholder('65163')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Select::make('person_id')
                    ->label('Contact Person')
                    ->options(
                        Customer::all()
                            ->where('type', CustomerConstant::TYPE_PERSON)
                            ->pluck('full_name', 'id')
                    )
                    ->default(null),
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
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
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
                Tables\Columns\TextColumn::make('industry')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('person_id')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_by')
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit'   => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', CustomerConstant::TYPE_COMPANY)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
