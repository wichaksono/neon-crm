<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
