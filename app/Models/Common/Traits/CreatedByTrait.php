<?php

namespace App\Models\Common\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait CreatedByTrait
{
    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
