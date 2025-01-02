<?php

namespace App\Filament\Resources\NoteResource\Pages;

use App\Filament\Resources\NoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditNote extends EditRecord
{
    protected static string $resource = NoteResource::class;

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
