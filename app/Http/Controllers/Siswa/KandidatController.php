<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;

class KandidatController extends Controller {
    public function index() {
        $kandidat = Kandidat::where('is_active', true)->orderBy('nomor_urut')->get();
        return view('siswa.kandidat', compact('kandidat'));
    }

    public function detail($id) {
        $kandidat = Kandidat::findOrFail($id);
        return view('siswa.kandidat-detail', compact('kandidat'));
    }
}