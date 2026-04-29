<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Setting, User, Vote, ActivityLog};
use Illuminate\Http\Request;

class SettingsController extends Controller {
    public function index() {
        $settings = Setting::pluck('value','key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request) {
        $keys = ['voting_open','show_result','nama_sekolah','tahun_ajaran','tanggal_mulai','tanggal_selesai'];
        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }
        // Handle checkbox toggles
        Setting::set('voting_open',  $request->has('voting_open')  ? 'true' : 'false');
        Setting::set('show_result',  $request->has('show_result')  ? 'true' : 'false');

        ActivityLog::record('update_settings','admin',session('admin_id'),'Update pengaturan sistem');
        return back()->with('success','Pengaturan berhasil disimpan.');
    }

    public function resetVoting(Request $request) {
        $request->validate(['konfirmasi'=>'required|in:RESET']);

        if (Setting::get('voting_open','false') === 'true')
            return back()->with('error','Tutup voting terlebih dahulu sebelum reset.');

        Vote::truncate();
        User::query()->update(['sudah_voting' => false]);
        ActivityLog::record('reset_voting','admin',session('admin_id'),'Reset semua data voting');
        return back()->with('success','Data voting berhasil direset.');
    }
}