@extends('layouts.admin')
@section('title','Pengumuman')
@section('page-title','Manajemen Pengumuman')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:1.25rem">
  <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">+ Buat Pengumuman</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>Judul</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($pengumuman as $p)
        <tr>
          <td><strong>{{ $p->judul }}</strong><br><small style="color:var(--gray-600)">{{ Str::limit($p->isi, 60) }}</small></td>
          <td><span class="badge {{ $p->is_published ? 'badge-success' : 'badge-warning' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
          <td style="white-space:nowrap">{{ $p->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex;gap:.3rem;flex-wrap:wrap">
              <a href="{{ route('admin.pengumuman.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('admin.pengumuman.toggle', $p->id) }}" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-sm" style="background:var(--info);color:#fff">{{ $p->is_published ? 'Unpublish' : 'Publish' }}</button>
              </form>
              <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pengumuman ini?')">
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
  <div style="padding:1rem 1.5rem">{{ $pengumuman->links() }}</div>
</div>
@endsection