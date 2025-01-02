<?php

namespace App\Filament\Resources\NoteTagResource\Pages;

use App\Filament\Resources\NoteTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditNoteTag extends EditRecord
{
    protected static string $resource = NoteTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }
}
