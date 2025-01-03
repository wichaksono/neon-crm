<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method find(int $id)
 */
class Product extends Model
{
    use SoftDeletes, CreatedByTrait;

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
