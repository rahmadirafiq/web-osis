@extends('layouts.admin')
@section('title', $pengumuman ? 'Edit Pengumuman' : 'Buat Pengumuman')
@section('page-title', $pengumuman ? 'Edit Pengumuman' : 'Buat Pengumuman Baru')

@section('content')
<div style="max-width:700px">
  <div class="card">
    <div class="card-header">
      <h3>{{ $pengumuman ? 'Edit' : 'Buat' }} Pengumuman</h3>
      <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)">← Kembali</a>
    </div>
    <div class="card-body">
      <form action="{{ $pengumuman ? route('admin.pengumuman.update', $pengumuman->id) : route('admin.pengumuman.store') }}" method="POST">
        @csrf
        @if($pengumuman) @method('PUT') @endif

        <div class="form-group">
          <label>Judul *</label>
          <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengumuman?->judul) }}" required>
        </div>
        <div class="form-group">
          <label>Isi Pengumuman *</label>
          <textarea name="isi" class="form-control" rows="8" required>{{ old('isi', $pengumuman?->isi) }}</textarea>
        </div>
        <div class="form-group">
          <label class="toggle-switch">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $pengumuman?->is_published) ? 'checked' : '' }}>
            <span class="toggle-track"></span>
            <span>Langsung Publish</span>
          </label>
        </div>
        <div style="display:flex;gap:.75rem">
          <button type="submit" class="btn btn-primary">💾 Simpan</button>
          <a href="{{ route('admin.pengumuman.index') }}" class="btn" style="background:var(--gray-100);color:var(--navy)">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection