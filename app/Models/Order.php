<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, CreatedByTrait;

    protected $fillable = [
        'order_number',
        'customer_id',
        'status',
        'order_date',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'grand_amount',
        'payment_status',
        'payment_method',
        'attachments',
        'notes',
        'created_by',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(OrderDiscount::class, 'order_id', 'id');
    }

    public function taxes(): HasMany
    {
        return $this->hasMany(OrderTax::class, 'order_id', 'id');
    }
}
