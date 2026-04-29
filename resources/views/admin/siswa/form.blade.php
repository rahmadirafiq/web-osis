@extends('layouts.admin')
@section('title', $siswa ? 'Edit Siswa' : 'Tambah Siswa')
@section('page-title', $siswa ? 'Edit Data Siswa' : 'Tambah Siswa Baru')

@section('content')
<div style="max-width:600px">
  <div class="card">
    <div class="card-header">
      <h3>{{ $siswa ? 'Edit' : 'Tambah' }} Data Siswa</h3>
      <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)">← Kembali</a>
    </div>
    <div class="card-body">
      <form action="{{ $siswa ? route('admin.siswa.update', $siswa->id) : route('admin.siswa.store') }}" method="POST">
        @csrf
        @if($siswa) @method('PUT') @endif

        <div class="form-group">
          <label>NISN *</label>
          <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa?->nisn) }}" {{ $siswa ? 'readonly' : 'required' }}>
          @error('nisn')<small style="color:var(--danger)">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
          <label>Nama Lengkap *</label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa?->nama) }}" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Kelas *</label>
            <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa?->kelas) }}" placeholder="XII IPA 1" required>
          </div>
          <div class="form-group">
            <label>Jurusan *</label>
            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $siswa?->jurusan) }}" placeholder="IPA" required>
          </div>
        </div>
        @if(!$siswa)
        <div class="form-group">
          <label>Password Awal *</label>
          <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        @endif
        <button type="submit" class="btn btn-primary">💾 Simpan</button>
      </form>
    </div>
  </div>
</div>
@endsection