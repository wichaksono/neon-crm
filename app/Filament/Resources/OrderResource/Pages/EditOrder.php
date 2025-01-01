<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Common\Constants\InvoiceConstant;
use App\Models\Common\Constants\RecurringConstant;
use App\Models\Common\Traits\OrderCalculateTrait;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\OrderTax;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditOrder extends EditRecord
{
    use OrderCalculateTrait;

    protected static string $resource = OrderResource::class;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load relasi yang diperlukan
        $this->record->load(['orderItems', 'discounts', 'taxes']);

        // Fill orderItems
        $data['orderItems'] = $this->record->orderItems->map(function ($item) {
            return [
                'product_id'   => $item->product_id,
                'custom_label' => $item->custom_label,
                'quantity'     => $item->quantity,
                'unit_price'   => $item->unit_price,
                'total_price'  => $item->total_price,
            ];
        })->toArray();

        // Fill discounts
        $data['discounts'] = $this->record->discounts->map(function ($discount) {
            return [
                'discount_id' => $discount->discount_id,
            ];
        })->toArray();

        // Fill taxes
        $data['taxes'] = $this->record->taxes->map(function ($tax) {
            return [
                'tax_id' => $tax->tax_id,
            ];
        })->toArray();


        /**
         * get from invoice
         */
        //payment_status
        $data['payment_status'] = InvoiceConstant::PAYMENT_STATUS_UNPAID;

        //payment_type: cash or installment
        $data['payment_type'] = InvoiceConstant::PAYMENT_TYPE_CASH;

        //payment_method
        $data['payment_method'] = InvoiceConstant::PAYMENT_METHOD_BANK_TRANSFER;

        //payment_method_name
        $data['payment_method_name'] = InvoiceConstant::PAYMENT_BANK_BCA;

        //recurring (recurring mode)
        $data['recurring'] = RecurringConstant::RECURRING_TYPE_ONCE;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->calculate($data);

        $data['total_amount']    = $this->getTotalAmount();
        $data['discount_amount'] = $this->getTotalDiscountAmount();
        $data['tax_amount']      = $this->getTotalTaxAmount();
        $data['grand_amount']    = $this->getGrandAmount();
        return $data;
    }

    /**
     * Lifecycle hook that runs after the record is saved.
     *
     * @see https://filamentphp.com/docs/3.x/panels/resources/editing-records#lifecycle-hooks
     */
    protected function afterSave(): void
    {
        $record = $this->getRecord();

        $orderId = $record->id;

        // Update order items
        OrderItem::updateItems($orderId, $this->getOrderItems());

        // Update discounts
        OrderDiscount::updateDiscounts($orderId, $this->getDiscounts());

        // Update taxes
        OrderTax::updateTaxes($orderId, $this->getTaxes());
    }
}
