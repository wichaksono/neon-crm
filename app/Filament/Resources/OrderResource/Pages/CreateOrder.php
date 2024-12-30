<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Common\Traits\OrderCalculateTrait;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

use function auth;

class CreateOrder extends CreateRecord
{
    use OrderCalculateTrait;

    protected static string $resource = OrderResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->calculate($data);

        $data['total_amount']    = $this->getTotalAmount();
        $data['discount_amount'] = $this->getTotalDiscountAmount();
        $data['tax_amount']      = $this->getTotalTaxAmount();
        $data['grand_amount']    = $this->getGrandAmount();
        $data['created_by']      = auth()->id();
        return $data;
    }

    /**
     * Lifecycle hook that is called after the record is created.
     *
     * @see https://filamentphp.com/docs/3.x/panels/resources/creating-records#lifecycle-hooks
     */
    public function afterCreate(): void
    {
        $record = $this->getRecord();

        // Create order items
        $record->orderItems()->createMany($this->getOrderItems());

        // Create discounts
        $record->discounts()->createMany($this->getDiscounts());

        // Create taxes
        $record->taxes()->createMany($this->getTaxes());
    }


    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::End;
    }

}
