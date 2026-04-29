<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kandidat, ActivityLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller {
    public function index() {
        $kandidat = Kandidat::orderBy('nomor_urut')->get();
        return view('admin.kandidat.index', compact('kandidat'));
    }

    public function create() {
        return view('admin.kandidat.form', ['kandidat' => null]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nomor_urut'   => 'required|integer|unique:kandidat,nomor_urut',
            'nama_ketua'   => 'required|string|max:100',
            'nama_wakil'   => 'required|string|max:100',
            'foto_ketua'   => 'nullable|image|max:2048',
            'foto_wakil'   => 'nullable|image|max:2048',
            'visi'         => 'required',
            'misi'         => 'required',
            'program_kerja'=> 'required',
            'is_active'    => 'boolean',
        ]);

        if ($request->hasFile('foto_ketua'))
            $data['foto_ketua'] = $request->file('foto_ketua')->store('foto', 'public');
        if ($request->hasFile('foto_wakil'))
            $data['foto_wakil'] = $request->file('foto_wakil')->store('foto', 'public');

        $data['is_active'] = $request->boolean('is_active', true);
        Kandidat::create($data);
        ActivityLog::record('create_kandidat','admin',session('admin_id'),"Tambah kandidat paslon {$data['nomor_urut']}");
        return redirect()->route('admin.kandidat.index')->with('success','Kandidat berhasil ditambahkan.');
    }

    public function edit($id) {
        $kandidat = Kandidat::findOrFail($id);
        return view('admin.kandidat.form', compact('kandidat'));
    }

    public function update(Request $request, $id) {
        $kandidat = Kandidat::findOrFail($id);

        $data = $request->validate([
            'nomor_urut'   => "required|integer|unique:kandidat,nomor_urut,{$id}",
            'nama_ketua'   => 'required|string|max:100',
            'nama_wakil'   => 'required|string|max:100',
            'foto_ketua'   => 'nullable|image|max:2048',
            'foto_wakil'   => 'nullable|image|max:2048',
            'visi'         => 'required',
            'misi'         => 'required',
            'program_kerja'=> 'required',
        ]);

        if ($request->hasFile('foto_ketua')) {
            if ($kandidat->foto_ketua) Storage::disk('public')->delete($kandidat->foto_ketua);
            $data['foto_ketua'] = $request->file('foto_ketua')->store('foto','public');
        }
        if ($request->hasFile('foto_wakil')) {
            if ($kandidat->foto_wakil) Storage::disk('public')->delete($kandidat->foto_wakil);
            $data['foto_wakil'] = $request->file('foto_wakil')->store('foto','public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $kandidat->update($data);
        ActivityLog::record('update_kandidat','admin',session('admin_id'),"Edit kandidat paslon {$kandidat->nomor_urut}");
        return redirect()->route('admin.kandidat.index')->with('success','Kandidat berhasil diperbarui.');
    }

    public function destroy($id) {
        $kandidat = Kandidat::findOrFail($id);
        if ($kandidat->foto_ketua) Storage::disk('public')->delete($kandidat->foto_ketua);
        if ($kandidat->foto_wakil) Storage::disk('public')->delete($kandidat->foto_wakil);
        $kandidat->delete();
        ActivityLog::record('delete_kandidat','admin',session('admin_id'),"Hapus kandidat paslon {$kandidat->nomor_urut}");
        return back()->with('success','Kandidat berhasil dihapus.');
    }
}