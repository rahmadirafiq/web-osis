<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{User, Vote, Pengumuman, Setting};

class DashboardController extends Controller {
    public function index() {
        $siswa        = User::findOrFail(session('siswa_id'));
        $totalSiswa   = User::count();
        $sudahVoting  = User::where('sudah_voting', true)->count();
        $belumVoting  = $totalSiswa - $sudahVoting;
        $pengumuman   = Pengumuman::where('is_published', true)->latest()->take(3)->get();
        $tanggalSelesai = Setting::get('tanggal_selesai');

        return view('siswa.dashboard', compact(
            'siswa', 'totalSiswa', 'sudahVoting', 'belumVoting',
            'pengumuman', 'tanggalSelesai'
        ));
    }
}