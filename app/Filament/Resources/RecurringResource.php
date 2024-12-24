<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecurringResource\Pages;
use App\Filament\Resources\RecurringResource\RelationManagers;
use App\Models\Recurring;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecurringResource extends Resource
{
    protected static ?string $model = Recurring::class;

    protected static ?string $navigationGroup = 'Systems';

    protected static ?string $navigationIcon = 'hugeicons-clock-03';

    protected static ?int $navigationSort = 150;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('recurring_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('recurring_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('recurring_data')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DateTimePicker::make('next_date')
                    ->required(),
                Forms\Components\TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recurring_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recurring_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('next_date')
                    ->dateTime()
                    ->sortable(),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRecurrings::route('/'),
            'edit' => Pages\EditRecurring::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
