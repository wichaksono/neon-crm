<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTax extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['order_id', 'tax_id'];

    protected $fillable = [
        'order_id',
        'tax_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public static function addTaxes(int $orderId, array $taxes): void
    {
        if (empty($taxes)) {
            return;
        }

        self::insert(array_map(function ($tax) use ($orderId) {
            return [
                'order_id' => $orderId,
                'tax_id'   => $tax['tax_id'],
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
        self::where('order_id', $orderId)->delete();
    }
}
