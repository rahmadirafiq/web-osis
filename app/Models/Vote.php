<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
    public $timestamps = false;
    protected $fillable = ['user_id', 'kandidat_id', 'token', 'voted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kandidat() {
        return $this->belongsTo(Kandidat::class);
    }
}