@extends('layouts.admin')
@section('title','Pengaturan')
@section('page-title','Pengaturan Sistem')

@section('content')
<div style="max-width:700px;display:flex;flex-direction:column;gap:1.5rem">

  <!-- MAIN SETTINGS -->
  <div class="card reveal">
    <div class="card-header"><h3>⚙️ Konfigurasi Sistem</h3></div>
    <div class="card-body">
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="form-row">
          <div class="form-group">
            <label>Nama Sekolah</label>
            <input type="text" name="nama_sekolah" class="form-control" value="{{ $settings['nama_sekolah'] ?? '' }}">
          </div>
          <div class="form-group">
            <label>Tahun Ajaran</label>
            <input type="text" name="tahun_ajaran" class="form-control" value="{{ $settings['tahun_ajaran'] ?? '' }}" placeholder="2024/2025">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Tanggal Mulai Voting</label>
            <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ $settings['tanggal_mulai'] ?? '' }}">
          </div>
          <div class="form-group">
            <label>Tanggal Selesai Voting</label>
            <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ $settings['tanggal_selesai'] ?? '' }}">
          </div>
        </div>

        <div style="display:flex;gap:2rem;margin-bottom:1.5rem;flex-wrap:wrap">
          <label class="toggle-switch">
            <input type="checkbox" name="voting_open" value="1" {{ ($settings['voting_open'] ?? 'false') === 'true' ? 'checked' : '' }}>
            <span class="toggle-track"></span>
            <span style="font-weight:600">🗳️ Buka Voting</span>
          </label>
          <label class="toggle-switch">
            <input type="checkbox" name="show_result" value="1" {{ ($settings['show_result'] ?? 'false') === 'true' ? 'checked' : '' }}>
            <span class="toggle-track"></span>
            <span style="font-weight:600">👁️ Tampilkan Hasil ke Siswa</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Pengaturan</button>
      </form>
    </div>
  </div>

  <!-- RESET VOTING -->
  <div class="card reveal" style="border:2px solid var(--danger)">
    <div class="card-header" style="background:#fff5f5">
      <h3 style="color:var(--danger)">⚠️ Zona Bahaya — Reset Data Voting</h3>
    </div>
    <div class="card-body">
      <div class="alert alert-danger">
        ⚠️ Tindakan ini akan menghapus SEMUA data suara dan mereset status voting seluruh siswa. Tidak dapat dibatalkan!
      </div>
      <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return confirm('PERINGATAN TERAKHIR: Yakin hapus semua data voting?')">
        @csrf
        <div class="form-group">
          <label>Ketik <strong>RESET</strong> untuk konfirmasi:</label>
          <input type="text" name="konfirmasi" class="form-control" placeholder="Ketik RESET di sini" required>
        </div>
        <button type="submit" class="btn btn-danger">🗑️ Reset Semua Data Voting</button>
      </form>
    </div>
  </div>

</div>
@endsection