<?php

namespace App\Models;

use App\Models\Common\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NoteTag extends Model
{
    use CreatedByTrait;

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class);
    }
}
