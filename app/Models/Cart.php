<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    /**
     * Properti yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Properti tipe data yang di-cast.
     */
    protected $casts = [
        'id' => 'string',  // Jika menggunakan UUID
    ];

    /**
     * Relasi ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
