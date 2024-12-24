<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

use function dd;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['price'] = $data['regular_price'];
        if ($data['sale_price'] > 0 && $data['sale_price'] < $data['regular_price']) {
            $data['price'] = $data['sale_price'];
        }

        return $data;
    }
}
