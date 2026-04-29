@extends('layouts.siswa')
@section('title','Kandidat')
@section('page-title','Lihat Kandidat')

@section('content')
<div class="page-header">
  <h1>Paslon Kandidat</h1>
  <p>Kenali lebih dekat calon pemimpin OSIS SMAN 1 Bukittinggi</p>
</div>

<div class="kandidat-grid">
  @foreach($kandidat as $k)
  <div class="kandidat-card reveal">
    <div class="kandidat-card-header">
      <div class="nomor-urut-badge">{{ $k->nomor_urut }}</div>
      <div class="kandidat-fotos">
        <div class="foto-box">
          @if($k->foto_ketua)
            <img src="{{ asset('storage/'.$k->foto_ketua) }}" alt="{{ $k->nama_ketua }}" class="foto-placeholder" style="display:flex">
          @else
            <div class="foto-placeholder">👤</div>
          @endif
          <small>Ketua</small>
        </div>
        <div class="foto-box">
          @if($k->foto_wakil)
            <img src="{{ asset('storage/'.$k->foto_wakil) }}" alt="{{ $k->nama_wakil }}" class="foto-placeholder" style="display:flex">
          @else
            <div class="foto-placeholder">👤</div>
          @endif
          <small>Wakil</small>
        </div>
      </div>
      <h3 style="font-size:1.1rem">Paslon {{ $k->nomor_urut }}</h3>
    </div>
    <div class="kandidat-card-body">
      <div class="kandidat-names">
        <h3>{{ $k->nama_ketua }}</h3>
        <p>& {{ $k->nama_wakil }}</p>
      </div>
      <p style="color:var(--gray-600);font-size:.85rem;margin-bottom:1rem">{{ Str::limit($k->visi, 100) }}</p>
      <a href="{{ route('siswa.kandidat.detail', $k->id) }}" class="btn btn-primary btn-block">
        📖 Lihat Detail
      </a>
    </div>
  </div>
  @endforeach
</div>
@endsection