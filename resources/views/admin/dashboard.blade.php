@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Overview Dashboard')

@section('content')
<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card"><div class="stat-icon navy">🎓</div><div class="stat-info"><p>Total Siswa</p><div class="stat-num" id="st-total">{{ $totalSiswa }}</div></div></div>
  <div class="stat-card"><div class="stat-icon green">✅</div><div class="stat-info"><p>Sudah Voting</p><div class="stat-num" id="st-sudah">{{ $sudahVoting }}</div></div></div>
  <div class="stat-card"><div class="stat-icon red">⏳</div><div class="stat-info"><p>Belum Voting</p><div class="stat-num" id="st-belum">{{ $belumVoting }}</div></div></div>
  <div class="stat-card"><div class="stat-icon gold">👥</div><div class="stat-info"><p>Total Kandidat</p><div class="stat-num">{{ $totalKandidat }}</div></div></div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
  <!-- REALCOUNT CHART -->
  <div class="card reveal">
    <div class="card-header">
      <h3>📊 Realcount Sementara</h3>
      <div style="display:flex;gap:.5rem;align-items:center">
        <span style="width:8px;height:8px;background:var(--success);border-radius:50%;animation:pulse 1s infinite"></span>
        <small style="color:var(--gray-600)">Live</small>
      </div>
    </div>
    <div class="card-body" id="realcountArea">
      @foreach($kandidat as $k)
      @php $pct = $totalVotes > 0 ? round($k->votes_count/$totalVotes*100,1) : 0; @endphp
      <div style="margin-bottom:1.25rem">
        <div class="progress-label">
          <span>Paslon {{ $k->nomor_urut }} — {{ $k->nama_ketua }} & {{ $k->nama_wakil }}</span>
          <span id="pct-{{ $k->id }}">{{ $pct }}% ({{ $k->votes_count }})</span>
        </div>
        <div class="progress-track">
          <div class="progress-bar {{ $loop->first ? '' : 'gold' }}" id="bar-{{ $k->id }}" data-width="{{ $pct }}"></div>
        </div>
      </div>
      @endforeach
      <p style="color:var(--gray-600);font-size:.8rem;margin-top:1rem">Total suara: <strong id="totalVotes">{{ $totalVotes }}</strong></p>
    </div>
  </div>

  <!-- QUICK ACTIONS -->
  <div class="card reveal">
    <div class="card-header"><h3>⚡ Quick Actions</h3></div>
    <div class="card-body" style="display:flex;flex-direction:column;gap:.75rem">
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @if(!$votingOpen)
          <input type="hidden" name="voting_open" value="1">
          <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Buka voting sekarang?')">🔓 Buka Voting</button>
        @else
          <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Tutup voting sekarang?')">🔒 Tutup Voting</button>
        @endif
      </form>
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @if(!$showResult)
          <input type="hidden" name="show_result" value="1">
          <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Tampilkan hasil ke siswa?')">👁️ Tampilkan Hasil</button>
        @else
          <button type="submit" class="btn btn-sm btn-block" style="background:var(--gray-200);color:var(--gray-800)" onclick="return confirm('Sembunyikan hasil?')">🙈 Sembunyikan Hasil</button>
        @endif
      </form>
      <a href="{{ route('admin.realcount') }}" class="btn btn-gold btn-block">📈 Lihat Realcount</a>
      <a href="{{ route('admin.realcount.excel') }}" class="btn btn-sm btn-block" style="background:var(--gray-100);color:var(--gray-800)">📥 Export Excel</a>
    </div>
  </div>
</div>

<!-- ACTIVITY LOGS -->
<div class="card reveal">
  <div class="card-header"><h3>📋 Log Aktivitas Terbaru</h3><a href="{{ route('admin.logs') }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)">Lihat Semua</a></div>
  <div class="table-responsive">
    <table>
      <thead><tr><th>Waktu</th><th>Role</th><th>Aksi</th><th>IP</th><th>Keterangan</th></tr></thead>
      <tbody>
        @foreach($logs as $log)
        <tr>
          <td style="white-space:nowrap;font-size:.8rem">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m H:i') }}</td>
          <td><span class="badge {{ $log->role === 'admin' ? 'badge-navy' : 'badge-info' }}">{{ $log->role }}</span></td>
          <td><code style="font-size:.78rem;background:var(--gray-100);padding:.15rem .4rem;border-radius:4px">{{ $log->action }}</code></td>
          <td style="font-size:.8rem;color:var(--gray-600)">{{ $log->ip_address }}</td>
          <td style="font-size:.82rem">{{ Str::limit($log->description, 50) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script>
// Animate progress bars
window.addEventListener('load', () => {
  document.querySelectorAll('.progress-bar').forEach(b => {
    const w = b.dataset.width;
    setTimeout(() => b.style.width = w+'%', 400);
  });
});

// Auto-refresh stats every 10 seconds
setInterval(async () => {
  try {
    const r = await fetch('/admin/stats');
    const d = await r.json();
    document.getElementById('st-total').textContent = d.totalSiswa;
    document.getElementById('st-sudah').textContent = d.sudahVoting;
    document.getElementById('st-belum').textContent = d.belumVoting;
    document.getElementById('totalVotes').textContent = d.totalVotes;
    const total = d.totalVotes;
    d.kandidat.forEach(k => {
      const pct = total > 0 ? Math.round(k.votes_count/total*1000)/10 : 0;
      const bar = document.getElementById('bar-'+k.id);
      const lbl = document.getElementById('pct-'+k.id);
      if (bar) bar.style.width = pct+'%';
      if (lbl) lbl.textContent = `${pct}% (${k.votes_count})`;
    });
  } catch(e){}
}, 10000);
</script>
@endsection