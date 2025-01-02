<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteTagRelation extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'note_id',
        'note_tag_id',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    public function noteTag(): BelongsTo
    {
        return $this->belongsTo(NoteTag::class);
    }
}
