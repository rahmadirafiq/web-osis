<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller {
    public function index() {
        $pengumuman = Pengumuman::where('is_published', true)->latest()->paginate(10);
        return view('siswa.pengumuman', compact('pengumuman'));
    }
}