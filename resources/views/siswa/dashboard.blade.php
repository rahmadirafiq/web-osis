@extends('layouts.siswa')
@section('title','Beranda')
@section('page-title','Beranda')

@section('content')
<!-- HERO -->
<div class="hero-card">
  <div>
    <h2>Halo, {{ $siswa->nama }}! <span class="hero-wave">👋</span></h2>
    <p>{{ $siswa->kelas }} · NISN: {{ $siswa->nisn }}</p>
    <div style="margin-top:1rem">
      @if($siswa->sudah_voting)
        <span class="badge badge-success" style="font-size:.85rem;padding:.4rem 1rem">✅ Sudah Memberikan Suara</span>
      @else
        <span class="badge badge-warning" style="font-size:.85rem;padding:.4rem 1rem">⏳ Belum Voting</span>
      @endif
    </div>
  </div>
  <div class="float-anim" style="font-size:5rem;opacity:.8">🗳️</div>
</div>

<!-- COUNTDOWN -->
@if($tanggalSelesai)
<div class="card reveal" style="margin-bottom:2rem">
  <div class="card-header">
    <h3>⏱️ Countdown Penutupan Voting</h3>
  </div>
  <div class="card-body" style="text-align:center">
    <div class="countdown-wrap" id="countdown">
      <div class="countdown-unit"><span class="countdown-num" id="cd-day">00</span><div class="countdown-lbl">Hari</div></div>
      <div class="countdown-unit"><span class="countdown-num" id="cd-hr">00</span><div class="countdown-lbl">Jam</div></div>
      <div class="countdown-unit"><span class="countdown-num" id="cd-min">00</span><div class="countdown-lbl">Menit</div></div>
      <div class="countdown-unit"><span class="countdown-num" id="cd-sec">00</span><div class="countdown-lbl">Detik</div></div>
    </div>
    <p style="color:var(--gray-600);font-size:.85rem;margin-top:.75rem">
      Voting ditutup pada: {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d F Y, H:i') }} WIB
    </p>
  </div>
</div>
@endif

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card reveal">
    <div class="stat-icon navy">👥</div>
    <div class="stat-info"><p>Total Pemilih</p><div class="stat-num">{{ $totalSiswa }}</div></div>
  </div>
  <div class="stat-card reveal">
    <div class="stat-icon green">✅</div>
    <div class="stat-info"><p>Sudah Voting</p><div class="stat-num">{{ $sudahVoting }}</div></div>
  </div>
  <div class="stat-card reveal">
    <div class="stat-icon red">⏳</div>
    <div class="stat-info"><p>Belum Voting</p><div class="stat-num">{{ $belumVoting }}</div></div>
  </div>
  <div class="stat-card reveal">
    <div class="stat-icon gold">📊</div>
    <div class="stat-info">
      <p>Partisipasi</p>
      <div class="stat-num">{{ $totalSiswa > 0 ? round($sudahVoting/$totalSiswa*100) : 0 }}%</div>
    </div>
  </div>
</div>

<!-- PENGUMUMAN TERBARU -->
@if($pengumuman->isNotEmpty())
<div class="card reveal">
  <div class="card-header">
    <h3>📢 Pengumuman Terbaru</h3>
    <a href="{{ route('siswa.pengumuman') }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)">Lihat Semua</a>
  </div>
  <div class="card-body" style="display:flex;flex-direction:column;gap:1rem">
    @foreach($pengumuman as $p)
    <div style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);padding:1rem;transition:box-shadow .2s" onmouseover="this.style.boxShadow='var(--shadow)'" onmouseout="this.style.boxShadow='none'">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem">
        <h4 style="color:var(--navy);font-size:.95rem">{{ $p->judul }}</h4>
        <small style="color:var(--gray-600);white-space:nowrap">{{ $p->created_at->diffForHumans() }}</small>
      </div>
      <p style="color:var(--gray-600);font-size:.85rem;margin-top:.35rem">{{ Str::limit($p->isi, 120) }}</p>
    </div>
    @endforeach
  </div>
</div>
@endif
@endsection

@section('scripts')
<script>
// Countdown
const deadline = new Date('{{ $tanggalSelesai }}').getTime();

function updateCountdown() {
  const now  = Date.now();
  const diff = deadline - now;

  if (diff <= 0) {
    ['cd-day','cd-hr','cd-min','cd-sec'].forEach(id => document.getElementById(id).textContent = '00');
    return;
  }

  const d  = Math.floor(diff / 86400000);
  const h  = Math.floor((diff % 86400000) / 3600000);
  const m  = Math.floor((diff % 3600000) / 60000);
  const s  = Math.floor((diff % 60000) / 1000);

  const pad = n => String(n).padStart(2,'0');

  function setFlip(id, val) {
    const el = document.getElementById(id);
    if (el && el.textContent !== pad(val)) {
      el.classList.remove('flip-anim');
      void el.offsetWidth;
      el.classList.add('flip-anim');
      el.textContent = pad(val);
    }
  }

  setFlip('cd-day', d);
  setFlip('cd-hr',  h);
  setFlip('cd-min', m);
  setFlip('cd-sec', s);
}

updateCountdown();
setInterval(updateCountdown, 1000);
</script>
@endsection