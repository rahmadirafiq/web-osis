@extends('layouts.siswa')
@section('title','Hasil Suara')
@section('page-title','Hasil Suara')

@section('extra-css')
@keyframes confetti-fall {
  0%   { transform: translateY(-20px) rotate(0deg); opacity:1; }
  100% { transform: translateY(100vh) rotate(720deg); opacity:0; }
}
@keyframes winner-pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(212,168,67,.4); }
  50%       { box-shadow: 0 0 0 20px rgba(212,168,67,0); }
}
@keyframes crown-bounce {
  0%,100% { transform: translateY(0) scale(1); }
  50%     { transform: translateY(-8px) scale(1.1); }
}
@keyframes slideUp {
  from { opacity:0; transform:translateY(30px); }
  to   { opacity:1; transform:translateY(0); }
}
.winner-card {
  background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy) 60%, var(--navy-light) 100%);
  border: 3px solid var(--gold);
  border-radius: 20px;
  padding: 2.5rem;
  margin-bottom: 2rem;
  animation: winner-pulse 2s infinite, slideUp .6s ease;
  position: relative;
  overflow: hidden;
  color: white;
  text-align: center;
}
.winner-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 30% 30%, rgba(212,168,67,.15), transparent 60%);
}
.winner-crown {
  font-size: 3rem;
  animation: crown-bounce 2s ease-in-out infinite;
  display: inline-block;
  margin-bottom: .5rem;
}
.winner-photos {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin: 1.5rem 0;
  flex-wrap: wrap;
}
.winner-photo-wrap {
  text-align: center;
}
.winner-photo {
  width: 110px; height: 110px;
  border-radius: 50%;
  border: 4px solid var(--gold);
  object-fit: cover;
  box-shadow: 0 8px 24px rgba(0,0,0,.4);
  background: var(--navy-light);
  display: flex; align-items: center; justify-content: center;
  font-size: 2.5rem;
}
.winner-photo-label {
  margin-top: .5rem;
  font-size: .78rem;
  color: rgba(255,255,255,.7);
}
.winner-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  color: var(--gold);
  font-weight: 700;
  margin: .5rem 0;
}
.winner-votes {
  font-size: 3rem;
  font-weight: 800;
  color: white;
  line-height: 1;
}
.winner-pct {
  font-size: 1.1rem;
  color: var(--gold-light);
}
.confetti-piece {
  position: fixed;
  width: 10px; height: 10px;
  border-radius: 2px;
  pointer-events: none;
  z-index: 9999;
  animation: confetti-fall linear forwards;
}
.kandidat-result-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1rem;
  box-shadow: var(--shadow);
  animation: slideUp .5s ease both;
  display: flex;
  align-items: center;
  gap: 1.25rem;
}
.kandidat-result-photo {
  width: 64px; height: 64px;
  border-radius: 50%;
  border: 3px solid var(--gray-200);
  object-fit: cover;
  background: var(--gray-100);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.8rem;
  flex-shrink: 0;
}
@endSection

@section('content')

@if(!$showResult)
  <div class="card" style="max-width:600px;margin:2rem auto">
    <div class="card-body status-page">
      <span class="status-icon">🔒</span>
      <h2>Hasil Belum Tersedia</h2>
      <p>Hasil perhitungan suara belum dipublikasikan. Pantau terus pengumuman resmi dari panitia pemilihan.</p>
    </div>
  </div>
@else

  @php
    $winner = $kandidat->sortByDesc('votes_count')->first();
  @endphp

  {{-- WINNER CARD --}}
  @if($totalVotes > 0 && $winner)
  <div class="winner-card" id="winnerCard">
    <div style="position:relative;z-index:1">
      <div class="winner-crown">👑</div>
      <div style="font-size:.9rem;color:rgba(255,255,255,.7);letter-spacing:2px;text-transform:uppercase;margin-bottom:.25rem">Pemenang</div>
      <div class="winner-name">Paslon {{ $winner->nomor_urut }} — {{ $winner->nama_ketua }} & {{ $winner->nama_wakil }}</div>

      <div class="winner-photos">
        <div class="winner-photo-wrap">
          @if($winner->foto_ketua)
            <img src="{{ asset('storage/'.$winner->foto_ketua) }}" class="winner-photo" alt="{{ $winner->nama_ketua }}">
          @else
            <div class="winner-photo">🧑</div>
          @endif
          <div class="winner-photo-label">{{ $winner->nama_ketua }}<br><small>Calon Ketua</small></div>
        </div>
        <div style="display:flex;align-items:center;color:var(--gold);font-size:2rem;font-weight:700">&</div>
        <div class="winner-photo-wrap">
          @if($winner->foto_wakil)
            <img src="{{ asset('storage/'.$winner->foto_wakil) }}" class="winner-photo" alt="{{ $winner->nama_wakil }}">
          @else
            <div class="winner-photo">🧑</div>
          @endif
          <div class="winner-photo-label">{{ $winner->nama_wakil }}<br><small>Calon Wakil</small></div>
        </div>
      </div>

      @php $winPct = $totalVotes > 0 ? round($winner->votes_count / $totalVotes * 100, 1) : 0; @endphp
      <div class="winner-votes">{{ $winner->votes_count }} <span style="font-size:1.2rem;font-weight:400">suara</span></div>
      <div class="winner-pct">{{ $winPct }}% dari total suara</div>
      <div style="margin-top:1rem;padding:.5rem 1rem;background:rgba(212,168,67,.15);border:1px solid rgba(212,168,67,.3);border-radius:8px;display:inline-block;font-size:.85rem;color:rgba(255,255,255,.8)">
        Total suara masuk: <strong style="color:var(--gold)">{{ $totalVotes }}</strong> suara
      </div>
    </div>
  </div>
  @endif

  <div class="page-header">
    <h1>Hasil Perolehan Suara</h1>
    <p>Rincian perolehan suara semua paslon</p>
  </div>

  @foreach($kandidat->sortByDesc('votes_count') as $i => $k)
  @php $pct = $totalVotes > 0 ? round($k->votes_count / $totalVotes * 100, 1) : 0; @endphp
  <div class="kandidat-result-card" style="animation-delay:{{ $i * .1 }}s; {{ $loop->first ? 'border-left:4px solid var(--gold)' : '' }}">
    @if($k->foto_ketua)
      <img src="{{ asset('storage/'.$k->foto_ketua) }}" class="kandidat-result-photo" alt="{{ $k->nama_ketua }}">
    @else
      <div class="kandidat-result-photo">👥</div>
    @endif
    <div style="flex:1">
      <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem">
        @if($loop->first) <span style="font-size:1.1rem">🥇</span> @elseif($loop->iteration==2) <span style="font-size:1.1rem">🥈</span> @else <span style="font-size:1.1rem">🥉</span> @endif
        <strong style="color:var(--navy)">Paslon {{ $k->nomor_urut }} — {{ $k->nama_ketua }} & {{ $k->nama_wakil }}</strong>
      </div>
      <div class="progress-track" style="margin:.5rem 0">
        <div class="progress-bar {{ $loop->first ? '' : 'gold' }}" data-width="{{ $pct }}" style="width:0%;transition:width 1s ease {{ $i * .15 }}s"></div>
      </div>
    </div>
    <div style="text-align:right;flex-shrink:0">
      <div style="font-size:1.6rem;font-weight:700;color:var(--navy);font-family:'Playfair Display',serif">{{ $pct }}%</div>
      <small style="color:var(--gray-600)">{{ $k->votes_count }} suara</small>
    </div>
  </div>
  @endforeach

@endif

@endsection

@section('scripts')
<script>
window.addEventListener('load', () => {
  document.querySelectorAll('.progress-bar').forEach(bar => {
    const w = bar.dataset.width;
    setTimeout(() => bar.style.width = w + '%', 300);
  });

  // Confetti animation for winner
  @if($showResult && $totalVotes > 0)
  const colors = ['#D4A843','#0B2545','#28a745','#dc3545','#ffc107','#e8c46a'];
  for (let i = 0; i < 60; i++) {
    setTimeout(() => {
      const el = document.createElement('div');
      el.className = 'confetti-piece';
      el.style.cssText = `
        left: ${Math.random()*100}vw;
        top: -10px;
        background: ${colors[Math.floor(Math.random()*colors.length)]};
        width: ${6+Math.random()*8}px;
        height: ${6+Math.random()*8}px;
        animation-duration: ${2+Math.random()*3}s;
        animation-delay: ${Math.random()*2}s;
        border-radius: ${Math.random()>.5?'50%':'2px'};
      `;
      document.body.appendChild(el);
      setTimeout(() => el.remove(), 5000);
    }, i * 80);
  }
  @endif
});
</script>
@endsection