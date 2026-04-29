@extends('layouts.admin')
@section('title','Data Siswa')
@section('page-title','Manajemen Data Siswa')

@section('content')
<!-- FILTER BAR -->
<div class="card" style="margin-bottom:1.25rem">
  <div class="card-body" style="padding:1rem 1.25rem">
    <form method="GET" action="{{ route('admin.siswa.index') }}">
      <div class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="🔍 Cari NISN / Nama..." value="{{ request('search') }}">
        <select name="kelas" class="form-control">
          <option value="">Semua Kelas</option>
          @foreach($kelasList as $k)<option value="{{ $k }}" {{ request('kelas')==$k?'selected':'' }}>{{ $k }}</option>@endforeach
        </select>
        <select name="jurusan" class="form-control">
          <option value="">Semua Jurusan</option>
          @foreach($jurusanList as $j)<option value="{{ $j }}" {{ request('jurusan')==$j?'selected':'' }}>{{ $j }}</option>@endforeach
        </select>
        <select name="voting" class="form-control">
          <option value="">Status Voting</option>
          <option value="1" {{ request('voting')==='1'?'selected':'' }}>Sudah Voting</option>
          <option value="0" {{ request('voting')==='0'?'selected':'' }}>Belum Voting</option>
        </select>
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.siswa.index') }}" class="btn" style="background:var(--gray-100);color:var(--navy)">Reset</a>
      </div>
    </form>
  </div>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:.75rem">
  <span style="color:var(--gray-600);font-size:.875rem">Total: {{ $siswa->total() }} siswa</span>
  <div style="display:flex;gap:.75rem">
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
    <button class="btn btn-sm" style="background:var(--gray-100);color:var(--navy)" onclick="document.getElementById('importModal').style.display='flex'">📥 Import CSV</button>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>NISN</th><th>Nama</th><th>Kelas</th><th>Jurusan</th><th>Voting</th><th>Aktif</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($siswa as $s)
        <tr>
          <td><code style="font-size:.82rem">{{ $s->nisn }}</code></td>
          <td><strong>{{ $s->nama }}</strong></td>
          <td>{{ $s->kelas }}</td>
          <td>{{ $s->jurusan }}</td>
          <td><span class="badge {{ $s->sudah_voting ? 'badge-success' : 'badge-warning' }}">{{ $s->sudah_voting ? 'Sudah' : 'Belum' }}</span></td>
          <td><span class="badge {{ $s->is_active ? 'badge-success' : 'badge-danger' }}">{{ $s->is_active ? 'Aktif' : 'Off' }}</span></td>
          <td>
            <div style="display:flex;gap:.3rem;flex-wrap:wrap">
              <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('admin.siswa.toggle', $s->id) }}" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-sm" style="background:var(--warning);color:#000" title="Toggle Aktif">{{ $s->is_active ? '🔒' : '🔓' }}</button>
              </form>
              <form action="{{ route('admin.siswa.reset', $s->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Reset password ke siswa123?')">
                @csrf
                <button class="btn btn-sm" style="background:var(--info);color:#fff" title="Reset Password">🔑</button>
              </form>
              @if(!$s->sudah_voting)
              <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus siswa ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" title="Hapus">🗑️</button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div style="padding:1rem 1.5rem">
    {{ $siswa->links() }}
  </div>
</div>

<!-- IMPORT MODAL -->
<div id="importModal" style="display:none">
  <div class="modal-backdrop" onclick="this.parentElement.style.display='none'">
    <div class="modal-box" onclick="event.stopPropagation()">
      <h3>📥 Import Siswa dari CSV</h3>
      <p>Format CSV: nisn,nama,kelas,jurusan (tanpa header baris pertama)</p>
      <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <input type="file" name="file" class="form-control" accept=".csv,.txt" required>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn" style="background:var(--gray-100);color:var(--gray-800)" onclick="document.getElementById('importModal').style.display='none'">Batal</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection