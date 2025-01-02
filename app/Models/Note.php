<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use CreatedByTrait, softDeletes;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'priority',
        'color',
        'created_by',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(NoteTag::class);
    }
}
