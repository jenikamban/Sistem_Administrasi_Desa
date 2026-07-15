<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});



// Public Verifikasi Surat
Route::get('/verifikasi-surat/{kode}', [\App\Http\Controllers\VerifikasiSuratController::class, 'verify'])->name('verifikasi.surat');

// Task 6: Portal Publikasi & Transparansi
Route::get('/informasi/berita', [\App\Http\Controllers\PortalBeritaController::class, 'index'])->name('portal.berita.index');
Route::get('/informasi/berita/{slug}', [\App\Http\Controllers\PortalBeritaController::class, 'show'])->name('portal.berita.show');
Route::get('/informasi/apbd', [\App\Http\Controllers\PortalApbdController::class, 'index'])->name('portal.apbd.index');

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin,Admin');

    // Task 2: Kependudukan
    Route::resource('/kartu-keluarga', \App\Http\Controllers\KartuKeluargaController::class)->middleware('role:Superadmin,Admin,Staf');
    Route::resource('/warga', \App\Http\Controllers\WargaController::class)->except(['show'])->middleware('role:Superadmin,Admin,Staf');
    Route::get('/warga/{warga}', [\App\Http\Controllers\WargaController::class, 'show'])->name('warga.show'); // Warga show can be accessed by any auth user
    Route::resource('/mutasi-penduduk', \App\Http\Controllers\MutasiPendudukController::class)->middleware('role:Superadmin,Admin,Staf');

    // Task 3: Surat Menyurat
    Route::resource('/surat-permohonan', \App\Http\Controllers\SuratPermohonanController::class);
    Route::post('/surat-permohonan/{surat_permohonan}/approve', [\App\Http\Controllers\SuratPermohonanController::class, 'approve'])->name('surat-permohonan.approve');
    Route::post('/surat-permohonan/{surat_permohonan}/reject', [\App\Http\Controllers\SuratPermohonanController::class, 'reject'])->name('surat-permohonan.reject');
    Route::get('/surat-permohonan/{surat_permohonan}/print', [\App\Http\Controllers\SuratPermohonanController::class, 'print'])->name('surat-permohonan.print');

    // Task 4: Bantuan Sosial
    Route::resource('/bantuan-sosial', \App\Http\Controllers\BantuanSosialController::class)->middleware('role:Superadmin,Admin,Staf');
    Route::resource('/penerima-bantuan', \App\Http\Controllers\PenerimaBantuanController::class)->middleware('role:Superadmin,Admin,Staf');
    // Task 5: Pengaduan dan Aspirasi
    Route::resource('/pengaduan', \App\Http\Controllers\PengaduanController::class);
    Route::post('/pengaduan/{pengaduan}/respond', [\App\Http\Controllers\PengaduanController::class, 'respond'])->name('pengaduan.respond')->middleware('role:Superadmin,Admin,Staf');

    // Task 6: Publikasi dan Transparansi
    Route::resource('/berita', \App\Http\Controllers\BeritaController::class)->middleware('role:Superadmin,Admin,Staf');
    Route::resource('/apbd', \App\Http\Controllers\ApbdRealisasiController::class)->middleware('role:Superadmin,Admin,Staf');

    // Task 8: Arsip Dokumen
    Route::resource('/arsip-dokumen', \App\Http\Controllers\ArsipDokumenController::class)->middleware('role:Superadmin,Staf');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
