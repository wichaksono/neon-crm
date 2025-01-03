<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $recordId)
 * @method static query()
 * @method static where(string $string, int $id)
 */
class Todo extends Model
{
    use CreatedByTrait;

    protected $fillable = [
        'title',
        'description',
        'status',
        'order',
        'color',
        'due_date',
        'completed_at',
        'created_by',
    ];
}
