<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'full_name',
        'nick_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'type',
        'industry',
        'website',
        'person_id',
        'avatar',
        'label',
        'created_by',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'person_id', 'id');
    }
}
