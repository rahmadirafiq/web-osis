<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Kandidat, Vote, Setting};

class HasilController extends Controller {
    public function index() {
        $showResult = Setting::get('show_result', 'false') === 'true';
        $kandidat   = [];
        $totalVotes = 0;

        if ($showResult) {
            $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
            $totalVotes = Vote::count();
        }

        return view('siswa.hasil', compact('showResult', 'kandidat', 'totalVotes'));
    }
}