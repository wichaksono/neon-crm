<?php

namespace App\Filament\Resources\NoteResource\Pages;

use App\Filament\Resources\NoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['description'] = json_decode($data['description'], true);
        return $data;
    }


    public function getHeading(): string | Htmlable
    {
        return view('filament.components.heading', [
            'createRoute' => route('filament.dashboard.resources.notes.create')
        ]);
    }

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }
}
