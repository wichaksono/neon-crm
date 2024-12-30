<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDiscount extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['order_id', 'discount_id'];  // Add composite key

    protected $fillable = [
        'order_id',
        'discount_id',
    ];

    // Add relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public static function addDiscounts(int $orderId, array $discounts): void
    {
        if (empty($discounts)) {
            return;
        }

        self::insert(array_map(function ($discount) use ($orderId) {
            return [
                'order_id'    => $orderId,
                'discount_id' => $discount['discount_id'],
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
        self::where('order_id', $orderId)->delete();
    }
}
