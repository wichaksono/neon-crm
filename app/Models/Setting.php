<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static updateOrCreate(array $attributes, array $values = [])
 */
class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'setting_key';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'setting_key',
        'setting_value',
        'autoload'
    ];

    protected $casts = [
        'autoload' => 'boolean',
    ];
}
