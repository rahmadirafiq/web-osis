<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller {
    public function index() {
        $pengumuman = Pengumuman::with('admin')->latest()->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create() {
        return view('admin.pengumuman.form', ['pengumuman' => null]);
    }

    public function store(Request $request) {
        $data = $request->validate(['judul'=>'required','isi'=>'required']);
        $data['created_by']   = session('admin_id');
        $data['is_published'] = $request->boolean('is_published');
        Pengumuman::create($data);
        return redirect()->route('admin.pengumuman.index')->with('success','Pengumuman disimpan.');
    }

    public function edit($id) {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, $id) {
        $p    = Pengumuman::findOrFail($id);
        $data = $request->validate(['judul'=>'required','isi'=>'required']);
        $data['is_published'] = $request->boolean('is_published');
        $p->update($data);
        return redirect()->route('admin.pengumuman.index')->with('success','Pengumuman diperbarui.');
    }

    public function destroy($id) {
        Pengumuman::findOrFail($id)->delete();
        return back()->with('success','Pengumuman dihapus.');
    }

    public function toggle($id) {
        $p = Pengumuman::findOrFail($id);
        $p->update(['is_published' => !$p->is_published]);
        return back()->with('success','Status pengumuman diperbarui.');
    }
}