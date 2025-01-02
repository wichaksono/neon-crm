<?php

namespace App\Filament\Resources\NoteTagResource\Pages;

use App\Filament\Resources\NoteTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNoteTags extends ListRecords
{
    protected static string $resource = NoteTagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('md')
                ->mutateFormDataUsing(function ($data) {
                    $data['created_by'] = auth()->id();
                    return $data;
                })
                ->createAnother(false),
        ];
    }
}
