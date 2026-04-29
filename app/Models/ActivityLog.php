<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
    public $timestamps  = false;
    protected $fillable = ['user_id', 'role', 'action', 'ip_address', 'description'];

    public static function record(
        string $action,
        string $role = 'siswa',
        ?int $userId = null,
        string $description = '',
        ?string $ip = null
    ): void {
        static::create([
            'user_id'     => $userId,
            'role'        => $role,
            'action'      => $action,
            'ip_address'  => $ip ?? request()->ip(),
            'description' => $description,
        ]);
    }
}