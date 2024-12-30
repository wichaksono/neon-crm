<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(int $taxId)
 */
class Tax extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'rate',
        'status',
        'created_by'
    ];
}
