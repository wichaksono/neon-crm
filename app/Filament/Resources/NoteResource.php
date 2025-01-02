<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoteResource\Pages;
use App\Filament\Resources\NoteResource\RelationManagers;
use App\Models\Common\Constants\NoteConstant;
use App\Models\Note;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'hugeicons-note-edit';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                Forms\Components\Section::make()
                    ->columnSpan(4)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('short_description')
                            ->required(),
                        Forms\Components\Builder::make('description')
                            ->label('Content')
                            ->blockNumbers(false)
                            ->blocks([
                                Builder\Block::make('heading')
                                    ->icon('hugeicons-heading')
                                    ->schema([
                                        Forms\Components\TextInput::make('heading')
                                            ->required(),
                                        Forms\Components\Select::make('level')
                                            ->options([
                                                'h1'  => 'Heading 1',
                                                'h2'  => 'Heading 2',
                                                'h3'  => 'Heading 3',
                                                'h4'  => 'Heading 4',
                                                'h5'  => 'Heading 5',
                                                'h6'  => 'Heading 6',
                                                'p'   => 'Paragraph',
                                                'div' => 'Division',
                                            ])
                                            ->required(),
                                    ]),
                                Builder\Block::make('paragraph')
                                    ->icon('hugeicons-paragraph')
                                    ->schema([
                                        Forms\Components\Textarea::make('content')
                                            ->hiddenLabel()
                                            ->required(),
                                    ]),
                                Builder\Block::make('editor')
                                    ->icon('hugeicons-property-edit')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->hiddenLabel()
                                            ->required(),
                                    ]),
                                Builder\Block::make('image')
                                    ->icon('hugeicons-image-01')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->hiddenLabel()
                                            ->image()
                                            ->required(),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Alt text')
                                            ->required(),
                                    ]),
                                Builder\Block::make('List Items')
                                    ->icon('hugeicons-paragraph-bullets-point-01')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Title')
                                            ->required(),
                                        Forms\Components\Repeater::make('items')
                                            ->schema([
                                                Forms\Components\TextInput::make('item')
                                                    ->label('Item')
                                                    ->required(),
                                            ])
                                            ->required(),
                                    ]),
                            ])
                            ->addActionLabel('Add a new block')
                            ->required(),
                    ]),
                Forms\Components\Section::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Select::make('priority')
                            ->required()
                            ->options(NoteConstant::PRIORITIES)
                            ->default(NoteConstant::PRIORITY_NORMAL)
                            ->columnSpanFull(),
                        Forms\Components\ColorPicker::make('color')
                            ->default('#ffffff')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
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
            'index'  => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit'   => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
