<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — OSIS SMAN 1 Bukittinggi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body>

<div class="login-page">
  <!-- LEFT PANEL -->
  <div class="login-left">
    <div class="login-illustration">
      <div class="login-school-icon float-anim">🏫</div>
      <h1>Pemilihan Ketua OSIS</h1>
      <p style="color:rgba(255,255,255,.7);margin-top:.5rem">SMAN 1 Bukittinggi</p>
      <p style="color:rgba(255,255,255,.5);font-size:.85rem;margin-top:.5rem">Tahun Pelajaran 2024/2025</p>
      <div class="login-deco-dots">
        <span></span><span></span><span></span>
      </div>
      <div style="margin-top:2.5rem;color:rgba(255,255,255,.6);font-size:.85rem;max-width:280px;line-height:1.8">
        "Suaramu menentukan masa depan organisasi kita. Gunakan hak pilihmu dengan bijak."
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="login-right">
    <div class="login-form-box" id="loginBox">
      <div class="logo-area">
        <div class="logo-circle">🏅</div>
        <h2>SMAN 1 Bukittinggi</h2>
        <p>Sistem Voting OSIS Digital</p>
      </div>

      <h3>Selamat Datang</h3>
      <p>Masuk dengan akun siswa atau admin Anda</p>

      @if(session('error'))
        <div class="alert alert-danger" id="errorAlert">
          ⚠️ {{ session('error') }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif

      <form action="/login" method="POST" id="loginForm">
        @csrf
        <div class="form-group">
          <label for="id_pengguna">ID Pengguna (NISN / NIS Admin)</label>
          <div class="input-icon-wrap">
            <span class="input-icon">🪪</span>
            <input
              type="text"
              id="id_pengguna"
              name="id_pengguna"
              class="form-control @error('id_pengguna') is-invalid @enderror"
              placeholder="Masukkan NISN atau NIS Admin"
              value="{{ old('id_pengguna') }}"
              autocomplete="username"
              required
            >
          </div>
          @error('id_pengguna')
            <small style="color:var(--danger)">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-icon-wrap" style="position:relative">
            <span class="input-icon">🔒</span>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control"
              placeholder="Masukkan password"
              autocomplete="current-password"
              style="padding-right:3rem"
              required
            >
            <button type="button" id="togglePw" onclick="togglePassword()"
              style="position:absolute;right:.85rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1.1rem;color:var(--gray-600);padding:0;line-height:1"
              title="Lihat/Sembunyikan Password">👁️</button>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="margin-top:1.25rem;padding:.9rem">
          🗳️ &nbsp;Masuk ke Sistem
        </button>
      </form>

      <p style="text-align:center;margin-top:1.5rem;color:var(--gray-600);font-size:.8rem">
        Lupa password? Hubungi administrator sekolah.
      </p>
    </div>
  </div>
</div>

<script>
  @if(session('error'))
    document.getElementById('loginBox').classList.add('shake');
    setTimeout(() => document.getElementById('loginBox').classList.remove('shake'), 600);
  @endif

  function togglePassword() {
    const pw  = document.getElementById('password');
    const btn = document.getElementById('togglePw');
    if (pw.type === 'password') {
      pw.type = 'text';
      btn.textContent = '🙈';
    } else {
      pw.type = 'password';
      btn.textContent = '👁️';
    }
  }
</script>

</body>
</html>