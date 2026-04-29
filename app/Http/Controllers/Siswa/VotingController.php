<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{User, Kandidat, Vote, ActivityLog, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VotingController extends Controller {
    public function index() {
        $siswa       = User::findOrFail(session('siswa_id'));
        $votingOpen  = Setting::get('voting_open', 'false') === 'true';
        $kandidat    = Kandidat::where('is_active', true)->orderBy('nomor_urut')->get();

        return view('siswa.voting', compact('siswa', 'votingOpen', 'kandidat'));
    }

    public function submit(Request $request) {
        $siswa = User::findOrFail(session('siswa_id'));

        if ($siswa->sudah_voting) {
            return back()->with('error', 'Anda sudah memberikan suara.');
        }

        if (Setting::get('voting_open', 'false') !== 'true') {
            return back()->with('error', 'Voting belum dibuka.');
        }

        $request->validate(['kandidat_id' => 'required|exists:kandidat,id']);

        // Anti double-vote: lock row
        $siswa->refresh();
        if ($siswa->sudah_voting) {
            return back()->with('error', 'Anda sudah memberikan suara.');
        }

        Vote::create([
            'user_id'     => $siswa->id,
            'kandidat_id' => $request->kandidat_id,
            'token'       => Str::uuid(),
            'voted_at'    => now(),
        ]);

        $siswa->update(['sudah_voting' => true]);

        ActivityLog::record('vote', 'siswa', $siswa->id, "Siswa '{$siswa->nama}' memberikan suara.");

        return redirect('/siswa/voting')->with('success', 'Suara Anda berhasil direkam!');
    }
}