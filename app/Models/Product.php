<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'price',
        'regular_price',
        'sale_price',
        'stock_quantity',
        'stock_unit',
        'is_active',
        'thumbnail',
        'created_by',
    ];

}
