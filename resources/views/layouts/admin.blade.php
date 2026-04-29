<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin — @yield('title','Dashboard') | OSIS SMAN 1 Bukittinggi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body>

<div class="app-wrapper">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">⚙️</div>
      <div class="sidebar-title">
        <h4>Admin Panel</h4>
        <p>OSIS SMAN 1 BKT</p>
      </div>
      <button class="sidebar-toggle" id="sidebarToggle">&#8249;</button>
    </div>

    <nav class="sidebar-nav">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <span class="nav-icon">📊</span><span class="nav-text">Dashboard</span>
      </a>
      <a href="{{ route('admin.realcount') }}" class="{{ request()->is('admin/realcount*') ? 'active' : '' }}">
        <span class="nav-icon">🔴</span><span class="nav-text">Live Realcount</span>
      </a>
      <a href="{{ route('admin.kandidat.index') }}" class="{{ request()->is('admin/kandidat*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span><span class="nav-text">Kandidat</span>
      </a>
      <a href="{{ route('admin.siswa.index') }}" class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
        <span class="nav-icon">🎓</span><span class="nav-text">Data Siswa</span>
      </a>
      <a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->is('admin/pengumuman*') ? 'active' : '' }}">
        <span class="nav-icon">📢</span><span class="nav-text">Pengumuman</span>
      </a>
      <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings') ? 'active' : '' }}">
        <span class="nav-icon">⚙️</span><span class="nav-text">Pengaturan</span>
      </a>
      <a href="{{ route('admin.logs') }}" class="{{ request()->is('admin/logs') ? 'active' : '' }}">
        <span class="nav-icon">📋</span><span class="nav-text">Log Aktivitas</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm" style="width:100%">
          <span>🚪</span><span class="nav-text">Logout</span>
        </button>
      </form>
    </div>
  </aside>

  <div class="main-content" id="mainContent">
    <header class="topbar" id="topbar">
      <button class="mobile-menu-btn" id="mobileMenuBtn" style="display:none;background:none;border:none;font-size:1.4rem;cursor:pointer;margin-right:.5rem;color:var(--navy)" title="Menu">☰</button>
      <span class="topbar-title">@yield('page-title','Admin')</span>
      <div class="topbar-user">
        <div class="topbar-avatar" style="background:linear-gradient(135deg,var(--gold-dark),var(--gold));color:var(--navy)">
          {{ mb_substr(session('admin_nama','A'),0,1) }}
        </div>
        <div class="topbar-user-info">
          <strong>{{ session('admin_nama') }}</strong>
          <small>Administrator</small>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
          @csrf
          <button class="btn btn-sm" style="background:var(--danger);color:var(--white);gap:.3rem">
            🚪 <span class="nav-text">Logout</span>
          </button>
        </form>
      </div>
    </header>

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
      © {{ date('Y') }} SMAN 1 Bukittinggi — Panel Admin OSIS
    </footer>
  </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
const sidebar     = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const topbar      = document.getElementById('topbar');

function isMobile() { return window.innerWidth <= 768; }

// Mobile overlay
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

// Mobile hamburger button
const mobileBtn = document.getElementById('mobileMenuBtn');
if (mobileBtn) mobileBtn.addEventListener('click', openMobileSidebar);

// Sidebar close arrow (only used on mobile)
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
const obs = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }), {threshold:.15});
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

function showToast(msg, type='success') {
  const c = document.getElementById('toastContainer');
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<span>${type==='success'?'✅':'❌'}</span><span>${msg}</span>`;
  c.appendChild(t);
  setTimeout(() => { t.classList.add('hiding'); setTimeout(()=>t.remove(),350); }, 3500);
}

function confirmAction(msg, form) {
  if (confirm(msg)) form.submit();
}
</script>

@yield('scripts')
</body>
</html>