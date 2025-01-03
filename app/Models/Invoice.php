<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, CreatedByTrait;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'due_date',
        'status',
        'subtotal_amount',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'payment_method',
        'payment_method_name',
        'payment_status',
        'payment_date',
        'notes',
        'created_by'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
