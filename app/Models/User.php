<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $fillable = [
        'nisn', 'nama', 'kelas', 'jurusan', 'password', 'role', 'sudah_voting', 'is_active'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'sudah_voting' => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}