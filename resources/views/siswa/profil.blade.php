@extends('layouts.siswa')
@section('title','Profil Saya')
@section('page-title','Profil Saya')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;max-width:900px">

  <!-- INFO PROFIL -->
  <div class="card reveal">
    <div class="card-header"><h3>👤 Data Diri</h3></div>
    <div class="card-body">
      <div style="text-align:center;margin-bottom:1.5rem">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--navy),var(--navy-light));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--gold);margin:0 auto;font-weight:700">
          {{ mb_substr($siswa->nama,0,1) }}
        </div>
        <h3 style="margin-top:.75rem;color:var(--navy)">{{ $siswa->nama }}</h3>
        <span class="badge {{ $siswa->sudah_voting ? 'badge-success' : 'badge-warning' }}" style="margin-top:.4rem">
          {{ $siswa->sudah_voting ? '✅ Sudah Voting' : '⏳ Belum Voting' }}
        </span>
      </div>

      <table style="width:100%;font-size:.9rem">
        <tr><td style="padding:.5rem 0;color:var(--gray-600);width:100px">NISN</td><td><strong>{{ $siswa->nisn }}</strong></td></tr>
        <tr><td style="padding:.5rem 0;color:var(--gray-600)">Kelas</td><td><strong>{{ $siswa->kelas }}</strong></td></tr>
        <tr><td style="padding:.5rem 0;color:var(--gray-600)">Jurusan</td><td><strong>{{ $siswa->jurusan }}</strong></td></tr>
        <tr><td style="padding:.5rem 0;color:var(--gray-600)">Status</td><td><span class="badge {{ $siswa->is_active ? 'badge-success' : 'badge-danger' }}">{{ $siswa->is_active ? 'Aktif' : 'Nonaktif' }}</span></td></tr>
      </table>
    </div>
  </div>

  <!-- GANTI PASSWORD -->
  <div class="card reveal">
    <div class="card-header"><h3>🔒 Ganti Password</h3></div>
    <div class="card-body">
      <form action="{{ route('siswa.profil.password') }}" method="POST">
        @csrf
        <div class="form-group">
          <label>Password Lama</label>
          <input type="password" name="password_lama" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password Baru</label>
          <input type="password" name="password_baru" class="form-control" required minlength="6">
        </div>
        <div class="form-group">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="password_baru_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">🔑 Ganti Password</button>
      </form>
    </div>
  </div>
</div>
@endsection