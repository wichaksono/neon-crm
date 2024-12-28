<?php

namespace App\Filament\Resources\TaxResource\Pages;

use App\Filament\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use function auth;

class CreateTax extends CreateRecord
{
    protected static string $resource = TaxResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }
}
