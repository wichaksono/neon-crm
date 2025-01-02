<?php

namespace App\Filament\Resources\NoteResource\Pages;

use App\Filament\Resources\NoteResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

use function auth;

class CreateNote extends CreateRecord
{
    protected static string $resource = NoteResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }
}
