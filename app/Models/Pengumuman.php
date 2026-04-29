<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model {
    protected $table    = 'pengumuman';
    protected $fillable = ['judul', 'isi', 'is_published', 'created_by'];

    protected $casts = ['is_published' => 'boolean'];

    public function admin() {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}