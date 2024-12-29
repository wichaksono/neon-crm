<?php

namespace App\Filament\Pages;

use App\Models\Common\Enum\TodoStatus;
use App\Models\Todo;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

use function array_search;

/**
 * Todos Filament Page
 *
 * @see KanbanBoard https://github.com/mokhosh/filament-kanban
 * @see Youtube Tutorial https://www.youtube.com/watch?v=QZP57DBtXrU&list=PL2KN3agjdhLZf6wgnJ09M6i7HvY09B0gX&index=1
 */
class Todos extends KanbanBoard
{
    protected static string $model = Todo::class;

    protected static string $statusEnum = TodoStatus::class;

    protected static string $recordTitleAttribute = 'title';

    protected static string $recordStatusAttribute = 'status';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $record = Todo::find($recordId);

        $update = [
            'status' => $status,
            'order'  => array_search($recordId, $toOrderedIds) + 1,
        ];

        if ($status == TodoStatus::Completed->value) {
            $update['completed_at'] = now();
        } else {
            $update['completed_at'] = null;
        }

        $record->update($update);
    }

    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Todo::where('id', $id)->update(['order' => $index + 1]);
        }
    }

    protected function getEloquentQuery(): Builder
    {
        return static::$model::query()->orderBy('order');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('Create Todo')
                ->model(Todo::class)
                ->createAnother(false)
                ->modalHeading('Create Todo')
                ->icon('heroicon-o-plus')
                ->label('Create Todo')
                ->form([
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description'),
                    Group::make([
                        ColorPicker::make('color')
                            ->label('Color')
                            ->default('#ffffff')
                            ->required(),
                        DateTimePicker::make('due_date')
                            ->label('Due Date')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options(TodoStatus::getStatuses())
                            ->default(TodoStatus::Pending->value)
                            ->required(),
                    ])->columns(3)
                ])->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = auth()->id();
                    $data['order']      = Todo::max('order') + 1;
                    return $data;
                }),
        ];
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->required(),
            Textarea::make('description')
                ->label('Description'),
            Group::make([
                ColorPicker::make('color')
                    ->label('Color')
                    ->default('#ffffff')
                    ->required(),
                DateTimePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options(TodoStatus::getStatuses())
                    ->default(TodoStatus::Pending->value)
                    ->required(),
            ])->columns(3),
        ];
    }
}
