<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Kandidat, Vote, ActivityLog, Setting};
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index() {
        $totalSiswa  = User::count();
        $sudahVoting = User::where('sudah_voting', true)->count();
        $belumVoting = $totalSiswa - $sudahVoting;
        $totalKandidat = Kandidat::count();
        $logs        = ActivityLog::orderByDesc('created_at')->take(10)->get();
        $kandidat    = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes  = Vote::count();
        $votingOpen  = Setting::get('voting_open', 'false') === 'true';
        $showResult  = Setting::get('show_result', 'false') === 'true';

        return view('admin.dashboard', compact(
            'totalSiswa','sudahVoting','belumVoting','totalKandidat',
            'logs','kandidat','totalVotes','votingOpen','showResult'
        ));
    }

    public function stats() {
        $totalSiswa  = User::count();
        $sudahVoting = User::where('sudah_voting', true)->count();
        $kandidat    = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes  = Vote::count();

        return response()->json([
            'totalSiswa'  => $totalSiswa,
            'sudahVoting' => $sudahVoting,
            'belumVoting' => $totalSiswa - $sudahVoting,
            'totalVotes'  => $totalVotes,
            'kandidat'    => $kandidat,
        ]);
    }
}