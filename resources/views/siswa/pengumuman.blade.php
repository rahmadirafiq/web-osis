@extends('layouts.siswa')
@section('title','Pengumuman')
@section('page-title','Pengumuman')

@section('content')
<div class="page-header">
  <h1>Pengumuman</h1>
  <p>Informasi resmi seputar kegiatan pemilihan OSIS</p>
</div>

@if($pengumuman->isEmpty())
  <div class="card"><div class="card-body status-page"><span class="status-icon">📭</span><h2>Belum Ada Pengumuman</h2></div></div>
@else
  <div style="display:flex;flex-direction:column;gap:1.25rem">
    @foreach($pengumuman as $p)
    <div class="card reveal" style="transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
      <div class="card-body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:.5rem;margin-bottom:.75rem">
          <h3 style="color:var(--navy);font-size:1.05rem">📌 {{ $p->judul }}</h3>
          <small style="color:var(--gray-600)">{{ $p->created_at->format('d M Y') }}</small>
        </div>
        <p style="color:var(--gray-700);line-height:1.8;white-space:pre-line">{{ $p->isi }}</p>
      </div>
    </div>
    @endforeach
  </div>
  <div class="pagination">{{ $pengumuman->links() }}</div>
@endif
@endsection