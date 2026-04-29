@extends('layouts.admin')
@section('title', $kandidat ? 'Edit Kandidat' : 'Tambah Kandidat')
@section('page-title', $kandidat ? 'Edit Kandidat' : 'Tambah Kandidat')

@section('content')
<div style="max-width:800px">
  <div class="card">
    <div class="card-header">
      <h3>{{ $kandidat ? 'Edit' : 'Tambah' }} Data Kandidat</h3>
      <a href="{{ route('admin.kandidat.index') }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)">← Kembali</a>
    </div>
    <div class="card-body">
      <form
        action="{{ $kandidat ? route('admin.kandidat.update', $kandidat->id) : route('admin.kandidat.store') }}"
        method="POST"
        enctype="multipart/form-data"
      >
        @csrf
        @if($kandidat) @method('PUT') @endif

        <div class="form-row">
          <div class="form-group">
            <label>Nomor Urut *</label>
            <input type="number" name="nomor_urut" class="form-control" value="{{ old('nomor_urut', $kandidat?->nomor_urut) }}" required>
            @error('nomor_urut')<small style="color:var(--danger)">{{ $message }}</small>@enderror
          </div>
          <div class="form-group">
            <label>Status Aktif</label>
            <label class="toggle-switch" style="margin-top:.5rem">
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', $kandidat?->is_active ?? true) ? 'checked' : '' }}>
              <span class="toggle-track"></span>
              <span>Aktif</span>
            </label>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Nama Calon Ketua *</label>
            <input type="text" name="nama_ketua" class="form-control" value="{{ old('nama_ketua', $kandidat?->nama_ketua) }}" required>
          </div>
          <div class="form-group">
            <label>Nama Calon Wakil *</label>
            <input type="text" name="nama_wakil" class="form-control" value="{{ old('nama_wakil', $kandidat?->nama_wakil) }}" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Foto Ketua (maks 2MB)</label>
            @if($kandidat?->foto_ketua)
              <img src="{{ asset('storage/'.$kandidat->foto_ketua) }}" class="photo-preview">
            @endif
            <input type="file" name="foto_ketua" class="form-control" accept="image/*" onchange="previewPhoto(this,'prev-ketua')">
            <img id="prev-ketua" class="photo-preview" style="display:none">
            @error('foto_ketua')<small style="color:var(--danger)">{{ $message }}</small>@enderror
          </div>
          <div class="form-group">
            <label>Foto Wakil (maks 2MB)</label>
            @if($kandidat?->foto_wakil)
              <img src="{{ asset('storage/'.$kandidat->foto_wakil) }}" class="photo-preview">
            @endif
            <input type="file" name="foto_wakil" class="form-control" accept="image/*" onchange="previewPhoto(this,'prev-wakil')">
            <img id="prev-wakil" class="photo-preview" style="display:none">
          </div>
        </div>

        <div class="form-group">
          <label>Visi *</label>
          <textarea name="visi" class="form-control" required rows="3">{{ old('visi', $kandidat?->visi) }}</textarea>
        </div>
        <div class="form-group">
          <label>Misi *</label>
          <textarea name="misi" class="form-control" required rows="5">{{ old('misi', $kandidat?->misi) }}</textarea>
        </div>
        <div class="form-group">
          <label>Program Kerja *</label>
          <textarea name="program_kerja" class="form-control" required rows="5">{{ old('program_kerja', $kandidat?->program_kerja) }}</textarea>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1rem">
          <button type="submit" class="btn btn-primary">💾 Simpan</button>
          <a href="{{ route('admin.kandidat.index') }}" class="btn" style="background:var(--gray-100);color:var(--navy)">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function previewPhoto(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection