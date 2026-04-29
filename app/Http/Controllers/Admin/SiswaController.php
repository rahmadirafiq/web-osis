<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, ActivityLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller {
    public function index(Request $request) {
        $q = User::query();
        if ($request->kelas)   $q->where('kelas', $request->kelas);
        if ($request->jurusan) $q->where('jurusan', $request->jurusan);
        if ($request->voting === '1') $q->where('sudah_voting', true);
        if ($request->voting === '0') $q->where('sudah_voting', false);
        if ($request->search)  $q->where(function($qb) use ($request) {
            $qb->where('nisn','like',"%{$request->search}%")
               ->orWhere('nama','like',"%{$request->search}%");
        });

        $siswa   = $q->orderBy('nama')->paginate(20)->withQueryString();
        $kelasList   = User::select('kelas')->distinct()->pluck('kelas');
        $jurusanList = User::select('jurusan')->distinct()->pluck('jurusan');

        return view('admin.siswa.index', compact('siswa','kelasList','jurusanList'));
    }

    public function create() {
        return view('admin.siswa.form', ['siswa' => null]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nisn'    => 'required|unique:users,nisn',
            'nama'    => 'required',
            'kelas'   => 'required',
            'jurusan' => 'required',
            'password'=> 'required|min:6',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.siswa.index')->with('success','Siswa berhasil ditambahkan.');
    }

    public function edit($id) {
        $siswa = User::findOrFail($id);
        return view('admin.siswa.form', compact('siswa'));
    }

    public function update(Request $request, $id) {
        $siswa = User::findOrFail($id);
        $data  = $request->validate([
            'nama'    => 'required',
            'kelas'   => 'required',
            'jurusan' => 'required',
        ]);
        $siswa->update($data);
        return redirect()->route('admin.siswa.index')->with('success','Data siswa diperbarui.');
    }

    public function destroy($id) {
        $siswa = User::findOrFail($id);
        if ($siswa->sudah_voting)
            return back()->with('error','Tidak bisa hapus siswa yang sudah voting.');
        $siswa->delete();
        return back()->with('success','Siswa berhasil dihapus.');
    }

    public function toggle($id) {
        $siswa = User::findOrFail($id);
        $siswa->update(['is_active' => !$siswa->is_active]);
        return back()->with('success','Status akun diperbarui.');
    }

    public function resetPassword($id) {
        $siswa = User::findOrFail($id);
        $siswa->update(['password' => Hash::make('siswa123')]);
        return back()->with('success','Password direset ke: siswa123');
    }

    public function import(Request $request) {
        $request->validate(['file' => 'required|mimes:csv,txt']);
        $file = $request->file('file');
        $rows = array_map('str_getcsv', file($file->getPathname()));
        array_shift($rows); // hapus header
        $count = 0;
        foreach ($rows as $row) {
            if (count($row) < 4) continue;
            [$nisn, $nama, $kelas, $jurusan] = $row;
            if (!User::where('nisn',$nisn)->exists()) {
                User::create([
                    'nisn'     => trim($nisn),
                    'nama'     => trim($nama),
                    'kelas'    => trim($kelas),
                    'jurusan'  => trim($jurusan),
                    'password' => Hash::make('siswa123'),
                ]);
                $count++;
            }
        }
        return back()->with('success',"{$count} siswa berhasil diimport.");
    }
}