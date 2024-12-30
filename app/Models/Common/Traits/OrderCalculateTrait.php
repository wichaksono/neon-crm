<?php

namespace App\Models\Common\Traits;


use App\Models\Common\Constants\DiscountConstant;
use App\Models\Common\Constants\TaxConstant;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Tax;

use function dd;

trait OrderCalculateTrait
{
    protected array $orderItems = [];

    protected array $discounts = [];

    protected array $taxes = [];

    protected int|float $totalAmount = 0;

    protected int|float $totalDiscountAmount = 0;

    protected int|float $totalTaxAmount = 0;

    /**
     * @param array{
     *     orderItems: array,
     *     discounts: array,
     *     taxes: array,
     * } $data
     *
     * @return void
     */
    protected function calculate(array $data):void
    {
        if ( ! empty($data['orderItems'])) {
            foreach ($data['orderItems'] as $item) {
                $product = Product::find($item['product_id']);

                $this->orderItems[] = [
                    'product_id'   => $item['product_id'],
                    'custom_label' => $item['custom_label'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $product->price,
                    'total_price'  => $product->price * $item['quantity'],
                ];

                $this->totalAmount += $product->price * $item['quantity'];
            }
        }

        if ( ! empty($data['discounts'])) {
            foreach ($data['discounts'] as $discountItem) {
                if ( ! empty($discountItem['discount_id'])) {
                    $discount = Discount::find($discountItem['discount_id']);
                    if ($discount->type === DiscountConstant::TYPE_PERCENTAGE) {
                        $discountAmount = $this->totalAmount * $discount->value / 100;
                    } else {
                        $discountAmount = $discount->value;
                    }

                    $this->discounts[] = [
                        'discount_id'     => $discountItem['discount_id'],
                        'discount_amount' => $discountAmount,
                    ];

                    $this->totalDiscountAmount += $discountAmount;
                }
            }
        }

        if ( ! empty($data['taxes'])) {
            foreach ($data['taxes'] as $taxItem) {
                if ( ! empty($taxItem['tax_id'])) {
                    $tax = Tax::find($taxItem['tax_id']);

                    if ($tax->type === TaxConstant::TYPE_PERCENTAGE) {

                        if ($this->totalAmount - $this->totalDiscountAmount <= 0) {
                            $taxAmount = $this->totalAmount * $tax->value / 100;
                        } else {
                            $taxAmount = ($this->totalAmount - $this->totalDiscountAmount) * $tax->rate / 100;
                        }
                    } else {
                        $taxAmount = $tax->rate;
                    }


                    $this->totalTaxAmount += $taxAmount;

                    $this->taxes[] = [
                        'tax_id'     => $taxItem['tax_id'],
                        'tax_amount' => $taxAmount,
                    ];
                }
            }
        }
    }

    protected function getTotalAmount():int|float
    {
        return $this->totalAmount;
    }

    protected function getTotalDiscountAmount():int|float
    {
        return $this->totalDiscountAmount;
    }

    protected function getTotalTaxAmount():int|float
    {
        return $this->totalTaxAmount;
    }

    protected function getGrandAmount():int|float
    {
        return $this->totalAmount - $this->totalDiscountAmount + $this->totalTaxAmount;
    }

    protected function getDiscounts():array
    {
        return $this->discounts;
    }

    protected function getTaxes():array
    {
        return $this->taxes;
    }

    protected function getOrderItems():array
    {
        return $this->orderItems;
    }
}
