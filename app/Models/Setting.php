<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    public $timestamps  = false;
    protected $fillable = ['key', 'value', 'label'];

    const UPDATED_AT = 'updated_at';

    public static function get(string $key, $default = null) {
        $s = static::where('key', $key)->first();
        return $s ? $s->value : $default;
    }

    public static function set(string $key, $value): void {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
    }
}