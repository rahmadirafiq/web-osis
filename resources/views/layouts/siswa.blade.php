<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Dashboard') — OSIS SMAN 1 Bukittinggi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<style>
  @yield('extra-css')
</style>
</head>
<body>

<div class="app-wrapper">
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">🏫</div>
      <div class="sidebar-title">
        <h4>OSIS SMAN 1</h4>
        <p>Bukittinggi</p>
      </div>
      <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">&#8249;</button>
    </div>

    <nav class="sidebar-nav">
      <a href="{{ route('siswa.dashboard') }}" class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span>
        <span class="nav-text">Beranda</span>
      </a>
      <a href="{{ route('siswa.kandidat') }}" class="{{ request()->is('siswa/kandidat*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span>
        <span class="nav-text">Lihat Kandidat</span>
      </a>
      <a href="{{ route('siswa.voting') }}" class="{{ request()->is('siswa/voting') ? 'active' : '' }}">
        <span class="nav-icon">🗳️</span>
        <span class="nav-text">Voting</span>
      </a>
      <a href="{{ route('siswa.hasil') }}" class="{{ request()->is('siswa/hasil') ? 'active' : '' }}">
        <span class="nav-icon">📊</span>
        <span class="nav-text">Hasil Suara</span>
      </a>
      <a href="{{ route('siswa.pengumuman') }}" class="{{ request()->is('siswa/pengumuman') ? 'active' : '' }}">
        <span class="nav-icon">📢</span>
        <span class="nav-text">Pengumuman</span>
      </a>
      <a href="{{ route('siswa.profil') }}" class="{{ request()->is('siswa/profil') ? 'active' : '' }}">
        <span class="nav-icon">👤</span>
        <span class="nav-text">Profil Saya</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm btn-block" style="width:100%">
          <span>🚪</span> <span class="nav-text">Logout</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content" id="mainContent">
    <!-- TOPBAR -->
    <header class="topbar" id="topbar">
      <button class="mobile-menu-btn" id="mobileMenuBtn" style="display:none;background:none;border:none;font-size:1.4rem;cursor:pointer;margin-right:.5rem;color:var(--navy)" title="Menu">☰</button>
      <span class="topbar-title">@yield('page-title','Dashboard')</span>
      <div class="topbar-user">
        <div class="topbar-avatar">{{ mb_substr(session('siswa_nama','S'),0,1) }}</div>
        <div class="topbar-user-info">
          <strong>{{ session('siswa_nama') }}</strong>
          <small>{{ session('siswa_kelas') }}</small>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
          @csrf
          <button class="btn btn-sm" style="background:var(--gray-100);color:var(--gray-800)">Logout</button>
        </form>
      </div>
    </header>

    <!-- CONTENT -->
    <main class="content-area">
      @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
      @endif

      @yield('content')
    </main>

    <footer class="app-footer">
      © {{ date('Y') }} SMAN 1 Bukittinggi — Pemilihan Ketua OSIS
    </footer>
  </div>
</div>

<!-- Toast container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Overlay for mobile sidebar -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
const sidebar     = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const topbar      = document.getElementById('topbar');

function isMobile() { return window.innerWidth <= 768; }

const overlay = document.getElementById('sidebarOverlay');

function openMobileSidebar() {
  sidebar.classList.add('mobile-open');
  overlay.classList.add('show');
}
function closeMobileSidebar() {
  sidebar.classList.remove('mobile-open');
  overlay.classList.remove('show');
}

overlay.addEventListener('click', closeMobileSidebar);

const mobileBtn = document.getElementById('mobileMenuBtn');
if (mobileBtn) mobileBtn.addEventListener('click', openMobileSidebar);

document.getElementById('sidebarToggle').addEventListener('click', () => {
  if (isMobile()) closeMobileSidebar();
});

function handleResize() {
  if (isMobile()) {
    if (mobileBtn) mobileBtn.style.display = 'flex';
    sidebar.classList.remove('collapsed');
    mainContent.style.marginLeft = '0';
    topbar.style.left = '0';
    closeMobileSidebar();
  } else {
    if (mobileBtn) mobileBtn.style.display = 'none';
    sidebar.classList.remove('collapsed');
    mainContent.classList.remove('collapsed');
    mainContent.style.marginLeft = '';
    topbar.style.left = '';
    closeMobileSidebar();
  }
}

window.addEventListener('resize', handleResize);
handleResize();

// Scroll reveal
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: .15 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

function showToast(msg, type='success') {
  const c    = document.getElementById('toastContainer');
  const t    = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<span>${type==='success'?'✅':'❌'}</span><span>${msg}</span>`;
  c.appendChild(t);
  setTimeout(() => { t.classList.add('hiding'); setTimeout(()=>t.remove(), 350); }, 3500);
}
</script>

@yield('scripts')
</body>
</html>