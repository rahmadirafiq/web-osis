<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Admin, ActivityLog};

class LoginController extends Controller {

    public function showForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'id_pengguna' => 'required',
            'password'    => 'required',
        ]);

        $id  = trim($request->id_pengguna);
        $pw  = $request->password;
        $ip  = $request->ip();

        // Coba login sebagai Admin
        $admin = Admin::where('nis', $id)->first();
        if ($admin) {
            if (!$admin->is_active) {
                return back()->withInput()->with('error', 'Akun admin tidak aktif.');
            }
            if (Hash::check($pw, $admin->password)) {
                session(['admin_id' => $admin->id, 'admin_nama' => $admin->nama]);
                ActivityLog::record('login', 'admin', $admin->id, "Admin '{$admin->nama}' login.", $ip);
                return redirect('/admin/dashboard');
            }
        }

        // Coba login sebagai Siswa
        $siswa = User::where('nisn', $id)->first();
        if ($siswa) {
            if (!$siswa->is_active) {
                ActivityLog::record('login_failed', 'siswa', $siswa->id, "Akun tidak aktif: NISN {$id}", $ip);
                return back()->withInput()->with('error', 'Akun Anda tidak aktif. Hubungi admin.');
            }
            if (Hash::check($pw, $siswa->password)) {
                session([
                    'siswa_id'    => $siswa->id,
                    'siswa_nama'  => $siswa->nama,
                    'siswa_kelas' => $siswa->kelas,
                    'siswa_nisn'  => $siswa->nisn,
                ]);
                ActivityLog::record('login', 'siswa', $siswa->id, "Siswa '{$siswa->nama}' login.", $ip);
                return redirect('/siswa/dashboard');
            }
        }

        ActivityLog::record('login_failed', 'siswa', null, "Login gagal untuk ID: {$id}", $ip);
        return back()->withInput()->with('error', 'ID atau password salah.');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}