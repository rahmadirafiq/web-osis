@extends('layouts.admin')
@section('title','Realcount')
@section('page-title','Live Realcount')

@section('content')
<div style="display:flex;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap">
  <a href="{{ route('admin.realcount.pdf') }}" class="btn btn-danger">📄 Export PDF</a>
  <a href="{{ route('admin.realcount.excel') }}" class="btn btn-success">📊 Export Excel</a>
  <button class="btn" style="background:var(--gray-100);color:var(--navy)" onclick="fetchData()">🔄 Refresh Manual</button>
  <span style="display:flex;align-items:center;gap:.4rem;color:var(--gray-600);font-size:.85rem">
    <span style="width:8px;height:8px;background:var(--success);border-radius:50%;animation:pulse 1s infinite;display:inline-block"></span>
    Auto-refresh 5 detik
  </span>
</div>

<div class="stats-grid" style="grid-template-columns:repeat(2,1fr)">
  <div class="stat-card">
    <div class="stat-icon green">🗳️</div>
    <div class="stat-info"><p>Total Suara Masuk</p><div class="stat-num" id="rc-total">{{ $totalVotes }}</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon navy">📊</div>
    <div class="stat-info"><p>Kandidat</p><div class="stat-num">{{ $kandidat->count() }}</div></div>
  </div>
</div>

@foreach($kandidat as $k)
@php $pct = $totalVotes > 0 ? round($k->votes_count/$totalVotes*100,1) : 0; @endphp
<div class="card reveal" style="margin-bottom:1.25rem" id="rc-card-{{ $k->id }}">
  <div class="card-body">
    <div style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap">
      <div class="nomor-urut-badge" style="width:60px;height:60px;font-size:1.5rem;flex-shrink:0">{{ $k->nomor_urut }}</div>
      <div style="flex:1">
        <h3 style="color:var(--navy);font-size:1.1rem">{{ $k->nama_ketua }} <span style="color:var(--gray-600)">&</span> {{ $k->nama_wakil }}</h3>
        <p style="color:var(--gray-600);font-size:.85rem">Paslon {{ $k->nomor_urut }}</p>
      </div>
      <div style="text-align:right">
        <div style="font-size:2.5rem;font-weight:700;color:var(--navy);font-family:'Playfair Display',serif" id="rc-pct-{{ $k->id }}">{{ $pct }}%</div>
        <div style="color:var(--gray-600);font-size:.9rem" id="rc-votes-{{ $k->id }}">{{ $k->votes_count }} suara</div>
      </div>
    </div>
    <div class="progress-track" style="height:20px;margin-top:1rem">
      <div class="progress-bar {{ $loop->first ? '' : 'gold' }}" id="rc-bar-{{ $k->id }}" style="width:{{ $pct }}%"></div>
    </div>
  </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
const kandidatIds = @json($kandidat->pluck('id'));

async function fetchData() {
  try {
    const r = await fetch('/admin/realcount/data');
    const d = await r.json();
    document.getElementById('rc-total').textContent = d.totalVotes;
    d.kandidat.forEach(k => {
      const pct = d.totalVotes > 0 ? Math.round(k.votes_count/d.totalVotes*1000)/10 : 0;
      const bar = document.getElementById('rc-bar-'+k.id);
      const p   = document.getElementById('rc-pct-'+k.id);
      const v   = document.getElementById('rc-votes-'+k.id);
      if (bar) bar.style.width = pct+'%';
      if (p)   p.textContent   = pct+'%';
      if (v)   v.textContent   = k.votes_count+' suara';
    });
  } catch(e){}
}

setInterval(fetchData, 5000);
</script>
@endsection