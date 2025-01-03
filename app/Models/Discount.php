<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(int $discountId)
 */
class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'value',
        'status',
        'start_date',
        'end_date',
        'created_by'
    ];
}
