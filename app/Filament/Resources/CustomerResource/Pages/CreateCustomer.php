<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Common\Constants\CustomerConstant;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['created_by'] = auth()->id();
        $data['type']       = CustomerConstant::TYPE_PERSON;

        return $data;
    }

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }
}
