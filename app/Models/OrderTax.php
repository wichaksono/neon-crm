<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderTax extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'tax_id',
    ];

    public static function addTaxes(int $orderId, array $taxes): void
    {
        DB::table('order_taxes')->insert(array_map(function ($tax) use ($orderId) {
            return [
                'order_id' => $orderId,
                'tax_id'   => $tax['id'],
            ];
        }, $taxes));
    }

    public static function updateTaxes(int $orderId, array $taxes): void
    {
        self::deleteTaxes($orderId);
        self::addTaxes($orderId, $taxes);
    }

    public static function deleteTaxes(int $orderId): void
    {
        DB::table('order_taxes')->where('order_id', $orderId)->delete();
    }
}
