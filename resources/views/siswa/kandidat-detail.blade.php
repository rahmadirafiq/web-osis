@extends('layouts.siswa')
@section('title','Detail Kandidat')
@section('page-title','Detail Kandidat')

@section('content')
<div style="max-width:800px;margin:0 auto">
  <div class="card reveal">
    <div style="background:linear-gradient(135deg,var(--navy),var(--navy-light));padding:2.5rem;text-align:center;color:var(--white)">
      <div class="nomor-urut-badge" style="width:70px;height:70px;font-size:2rem;margin:0 auto 1.5rem">{{ $kandidat->nomor_urut }}</div>
      <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:.5rem">Paslon {{ $kandidat->nomor_urut }}</h1>
      <div style="display:flex;gap:2rem;justify-content:center;margin-top:1.5rem">
        <div style="text-align:center">
          @if($kandidat->foto_ketua)
            <img src="{{ asset('storage/'.$kandidat->foto_ketua) }}" alt="" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid var(--gold);margin:0 auto">
          @else
            <div style="width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.15);border:4px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto">👤</div>
          @endif
          <div style="margin-top:.75rem">
            <strong style="display:block;font-size:1rem">{{ $kandidat->nama_ketua }}</strong>
            <small style="color:rgba(255,255,255,.7)">Calon Ketua</small>
          </div>
        </div>
        <div style="display:flex;align-items:center;color:var(--gold);font-size:1.5rem">&</div>
        <div style="text-align:center">
          @if($kandidat->foto_wakil)
            <img src="{{ asset('storage/'.$kandidat->foto_wakil) }}" alt="" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid var(--gold);margin:0 auto">
          @else
            <div style="width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.15);border:4px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto">👤</div>
          @endif
          <div style="margin-top:.75rem">
            <strong style="display:block;font-size:1rem">{{ $kandidat->nama_wakil }}</strong>
            <small style="color:rgba(255,255,255,.7)">Calon Wakil</small>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body" style="display:flex;flex-direction:column;gap:2rem">
      <div class="reveal">
        <h3 style="color:var(--navy);font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:.75rem;padding-bottom:.5rem;border-bottom:2px solid var(--gold)">🎯 Visi</h3>
        <p style="color:var(--gray-800);line-height:1.8">{{ $kandidat->visi }}</p>
      </div>
      <div class="reveal">
        <h3 style="color:var(--navy);font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:.75rem;padding-bottom:.5rem;border-bottom:2px solid var(--gold)">🚀 Misi</h3>
        <div style="color:var(--gray-800);line-height:2;white-space:pre-line">{{ $kandidat->misi }}</div>
      </div>
      <div class="reveal">
        <h3 style="color:var(--navy);font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:.75rem;padding-bottom:.5rem;border-bottom:2px solid var(--gold)">📋 Program Kerja</h3>
        <div style="color:var(--gray-800);line-height:2;white-space:pre-line">{{ $kandidat->program_kerja }}</div>
      </div>

      <div style="text-align:center;padding-top:1rem">
        <a href="{{ route('siswa.voting') }}" class="btn btn-gold" style="padding:1rem 2.5rem;font-size:1rem">
          🗳️ Berikan Suara Sekarang
        </a>
        <a href="{{ route('siswa.kandidat') }}" class="btn" style="margin-left:.75rem;background:var(--gray-100);color:var(--navy)">
          ← Kembali
        </a>
      </div>
    </div>
  </div>
</div>
@endsection