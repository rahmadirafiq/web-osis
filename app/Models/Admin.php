<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {
    protected $fillable = ['nis', 'nama', 'password', 'is_active'];
    protected $hidden   = ['password'];

    protected $casts = ['is_active' => 'boolean'];

    public function pengumuman() {
        return $this->hasMany(Pengumuman::class, 'created_by');
    }
}