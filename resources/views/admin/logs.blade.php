@extends('layouts.admin')
@section('title','Log Aktivitas')
@section('page-title','Log Aktivitas Sistem')

@section('content')
<div class="card" style="margin-bottom:1.25rem">
  <div class="card-body" style="padding:1rem 1.25rem">
    <form method="GET">
      <div class="filter-bar">
        <select name="role" class="form-control">
          <option value="">Semua Role</option>
          <option value="siswa" {{ request('role')==='siswa'?'selected':'' }}>Siswa</option>
          <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
        </select>
        <input type="text" name="action" class="form-control" placeholder="Filter aksi..." value="{{ request('action') }}">
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.logs') }}" class="btn" style="background:var(--gray-100);color:var(--navy)">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>Waktu</th><th>User ID</th><th>Role</th><th>Aksi</th><th>IP Address</th><th>Keterangan</th></tr></thead>
      <tbody>
        @foreach($logs as $log)
        <tr>
          <td style="white-space:nowrap;font-size:.82rem">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
          <td>{{ $log->user_id ?? '-' }}</td>
          <td><span class="badge {{ $log->role === 'admin' ? 'badge-navy' : 'badge-info' }}">{{ $log->role }}</span></td>
          <td><code style="font-size:.78rem;background:var(--gray-100);padding:.15rem .4rem;border-radius:4px">{{ $log->action }}</code></td>
          <td style="font-size:.82rem;color:var(--gray-600)">{{ $log->ip_address }}</td>
          <td style="font-size:.82rem">{{ $log->description }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div style="padding:.75rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;border-top:1px solid var(--gray-200)">
    <small style="color:var(--gray-600)">
      Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} data
    </small>
    <div style="display:flex;gap:.35rem;align-items:center">
      @if($logs->onFirstPage())
        <span style="padding:.3rem .7rem;border:1px solid var(--gray-200);border-radius:6px;color:var(--gray-400);font-size:.82rem;cursor:default">‹</span>
      @else
        <a href="{{ $logs->previousPageUrl() }}" style="padding:.3rem .7rem;border:1px solid var(--gray-200);border-radius:6px;color:var(--navy);font-size:.82rem;text-decoration:none;transition:background .2s" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">‹</a>
      @endif

      @foreach($logs->getUrlRange(max(1,$logs->currentPage()-2), min($logs->lastPage(),$logs->currentPage()+2)) as $page => $url)
        @if($page == $logs->currentPage())
          <span style="padding:.3rem .7rem;background:var(--navy);color:white;border-radius:6px;font-size:.82rem;font-weight:600">{{ $page }}</span>
        @else
          <a href="{{ $url }}" style="padding:.3rem .7rem;border:1px solid var(--gray-200);border-radius:6px;color:var(--navy);font-size:.82rem;text-decoration:none;transition:background .2s" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">{{ $page }}</a>
        @endif
      @endforeach

      @if($logs->hasMorePages())
        <a href="{{ $logs->nextPageUrl() }}" style="padding:.3rem .7rem;border:1px solid var(--gray-200);border-radius:6px;color:var(--navy);font-size:.82rem;text-decoration:none;transition:background .2s" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">›</a>
      @else
        <span style="padding:.3rem .7rem;border:1px solid var(--gray-200);border-radius:6px;color:var(--gray-400);font-size:.82rem;cursor:default">›</span>
      @endif
    </div>
  </div>
</div>
@endsection