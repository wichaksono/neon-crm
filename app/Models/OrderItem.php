<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['order_id', 'product_id'];

    protected $fillable = [
        'order_id',
        'product_id',
        'custom_label',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Your static methods look good, but updateItems could be improved
    public static function updateItems(int $orderId, array $items): void
    {
        // First delete existing items
        self::deleteItems($orderId);
        // Then add new items
        self::addItems($orderId, $items);
    }

    public static function addItems(int $orderId, array $items): void
    {
        self::insert(array_map(function ($item) use ($orderId) {
            return [
                'order_id'     => $orderId,
                'product_id'   => $item['product_id'],
                'custom_label' => $item['custom_label'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'total_price'  => $item['total_price'],
            ];
        }, $items));
    }

    public static function deleteItems(int $orderId): void
    {
        self::where('order_id', $orderId)->delete();
    }
}
