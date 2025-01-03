<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(int $taxId)
 */
class Tax extends Model
{
    use SoftDeletes, CreatedByTrait;

    protected $fillable = [
        'name',
        'rate',
        'status',
        'created_by'
    ];
}
