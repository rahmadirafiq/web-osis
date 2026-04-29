<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Siswa\{
    DashboardController as SiswaDashboard,
    KandidatController  as SiswaKandidat,
    VotingController,
    HasilController,
    PengumumanController as SiswaPengumuman,
    ProfilController
};
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    RealcountController,
    KandidatController  as AdminKandidat,
    SiswaController     as AdminSiswa,
    PengumumanController as AdminPengumuman,
    SettingsController,
    LogController
};

// Root
Route::get('/', fn() => redirect('/login'));

// Auth
Route::get ('/login',  [LoginController::class, 'showForm'])->name('login')->middleware('guest.custom');
Route::post('/login',  [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── SISWA ────────────────────────────────────────────────
Route::prefix('siswa')->middleware('auth.siswa')->group(function () {
    Route::get('/dashboard',    [SiswaDashboard::class,  'index'])->name('siswa.dashboard');
    Route::get('/kandidat',     [SiswaKandidat::class,   'index'])->name('siswa.kandidat');
    Route::get('/kandidat/{id}',[SiswaKandidat::class,   'detail'])->name('siswa.kandidat.detail');
    Route::get('/voting',       [VotingController::class,'index'])->name('siswa.voting');
    Route::post('/voting',      [VotingController::class,'submit'])->name('siswa.voting.submit');
    Route::get('/hasil',        [HasilController::class, 'index'])->name('siswa.hasil');
    Route::get('/pengumuman',   [SiswaPengumuman::class, 'index'])->name('siswa.pengumuman');
    Route::get('/profil',       [ProfilController::class,'index'])->name('siswa.profil');
    Route::post('/profil/password', [ProfilController::class,'changePassword'])->name('siswa.profil.password');
});

// ── ADMIN ────────────────────────────────────────────────
Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('/dashboard',  [AdminDashboard::class,'index'])->name('admin.dashboard');

    // Realcount
    Route::get('/realcount',       [RealcountController::class,'index'])->name('admin.realcount');
    Route::get('/realcount/data',  [RealcountController::class,'data'])->name('admin.realcount.data');
    Route::get('/realcount/export-pdf',   [RealcountController::class,'exportPdf'])->name('admin.realcount.pdf');
    Route::get('/realcount/export-excel', [RealcountController::class,'exportExcel'])->name('admin.realcount.excel');

    // Kandidat
    Route::resource('/kandidat', AdminKandidat::class)->except(['show'])->names('admin.kandidat');

    // Siswa
    Route::get   ('/siswa',              [AdminSiswa::class,'index'])->name('admin.siswa.index');
    Route::get   ('/siswa/create',       [AdminSiswa::class,'create'])->name('admin.siswa.create');
    Route::post  ('/siswa',              [AdminSiswa::class,'store'])->name('admin.siswa.store');
    Route::get   ('/siswa/{id}/edit',    [AdminSiswa::class,'edit'])->name('admin.siswa.edit');
    Route::put   ('/siswa/{id}',         [AdminSiswa::class,'update'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}',         [AdminSiswa::class,'destroy'])->name('admin.siswa.destroy');
    Route::post  ('/siswa/{id}/toggle',  [AdminSiswa::class,'toggle'])->name('admin.siswa.toggle');
    Route::post  ('/siswa/{id}/reset-password', [AdminSiswa::class,'resetPassword'])->name('admin.siswa.reset');
    Route::post  ('/siswa/import',       [AdminSiswa::class,'import'])->name('admin.siswa.import');

    // Pengumuman
    Route::resource('/pengumuman', AdminPengumuman::class)->except(['show'])->names('admin.pengumuman');
    Route::post('/pengumuman/{id}/toggle', [AdminPengumuman::class,'toggle'])->name('admin.pengumuman.toggle');

    // Settings
    Route::get ('/settings',       [SettingsController::class,'index'])->name('admin.settings');
    Route::post('/settings',       [SettingsController::class,'update'])->name('admin.settings.update');
    Route::post('/settings/reset-voting', [SettingsController::class,'resetVoting'])->name('admin.settings.reset');

    // Logs
    Route::get('/logs', [LogController::class,'index'])->name('admin.logs');

    // Dashboard stats AJAX
    Route::get('/stats', [AdminDashboard::class,'stats'])->name('admin.stats');
});