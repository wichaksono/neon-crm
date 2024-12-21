<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{

    protected $fillable = [
        'historical_id',
        'historical_type',
        'code',
        'message',
        'created_by',
    ];

    public static function add($historical_id, $historical_type, $code, $message, $created_by = null): void
    {
        DB::table('histories')->updateOrInsert([
            'historical_id' => $historical_id,
            'historical_type' => $historical_type,
            'code' => $code,
            'message' => $message,
            'created_by' => $created_by,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
