<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 
        'value', 
        'group', 
        'description'
    ];

    // Get a configuration value by key
    public static function getValue($key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    // Set a configuration value
    public static function setValue($key, $value, $group = null, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'description' => $description
            ]
        );
    }
}