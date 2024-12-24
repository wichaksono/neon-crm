<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

use function auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

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
