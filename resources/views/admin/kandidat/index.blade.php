@extends('layouts.admin')
@section('title','Kandidat')
@section('page-title','Manajemen Kandidat')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
  <div></div>
  <a href="{{ route('admin.kandidat.create') }}" class="btn btn-primary">+ Tambah Kandidat</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>No</th><th>Foto</th><th>Paslon</th><th>Ketua</th><th>Wakil</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($kandidat as $k)
        <tr>
          <td>{{ $k->nomor_urut }}</td>
          <td>
            @if($k->foto_ketua)
              <img src="{{ asset('storage/'.$k->foto_ketua) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
            @else
              <div style="width:40px;height:40px;border-radius:50%;background:var(--gray-200);display:flex;align-items:center;justify-content:center">👤</div>
            @endif
          </td>
          <td><strong>Paslon {{ $k->nomor_urut }}</strong></td>
          <td>{{ $k->nama_ketua }}</td>
          <td>{{ $k->nama_wakil }}</td>
          <td><span class="badge {{ $k->is_active ? 'badge-success' : 'badge-danger' }}">{{ $k->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
          <td>
            <div style="display:flex;gap:.4rem">
              <a href="{{ route('admin.kandidat.edit', $k->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('admin.kandidat.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kandidat ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection