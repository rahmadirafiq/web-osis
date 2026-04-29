<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller {
    public function index() {
        $siswa = User::findOrFail(session('siswa_id'));
        return view('siswa.profil', compact('siswa'));
    }

    public function changePassword(Request $request) {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $siswa = User::findOrFail(session('siswa_id'));

        if (!Hash::check($request->password_lama, $siswa->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $siswa->update(['password' => Hash::make($request->password_baru)]);
        return back()->with('success', 'Password berhasil diubah.');
    }
}