<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model {
    protected $table    = 'kandidat';
    protected $fillable = [
        'nomor_urut', 'nama_ketua', 'nama_wakil',
        'foto_ketua', 'foto_wakil', 'visi', 'misi', 'program_kerja', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}