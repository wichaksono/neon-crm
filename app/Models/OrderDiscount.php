<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderDiscount extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'discount_id',
    ];

    public static function addDiscounts(int $orderId, array $discounts): void
    {
        DB::table('order_discounts')->insert(array_map(function ($discount) use ($orderId) {
            return [
                'order_id'    => $orderId,
                'discount_id' => $discount['id'],
            ];
        }, $discounts));
    }

    public static function updateDiscounts(int $orderId, array $discounts): void
    {
        self::deleteDiscounts($orderId);
        self::addDiscounts($orderId, $discounts);
    }

    public static function deleteDiscounts(int $orderId): void
    {
        DB::table('order_discounts')->where('order_id', $orderId)->delete();
    }
}
