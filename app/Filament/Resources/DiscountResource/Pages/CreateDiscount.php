<?php

namespace App\Filament\Resources\DiscountResource\Pages;

use App\Filament\Resources\DiscountResource;
use App\Models\Common\Constants\CustomerConstant;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use function auth;

class CreateDiscount extends CreateRecord
{
    protected static string $resource = DiscountResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }
}
