<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

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
        'company_id',
        'industry',
        'website',
        'person_id',
        'avatar',
        'label',
        'created_by',
    ];
    //

    public function getCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
