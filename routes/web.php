<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

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

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');

    // Task 2: Kependudukan
    Route::resource('/kartu-keluarga', \App\Http\Controllers\KartuKeluargaController::class)->middleware('role:Superadmin,Staf');
    Route::resource('/warga', \App\Http\Controllers\WargaController::class)->except(['show'])->middleware('role:Superadmin,Staf');
    Route::get('/warga/{warga}', [\App\Http\Controllers\WargaController::class, 'show'])->name('warga.show'); // Warga show can be accessed by any auth user
    Route::resource('/mutasi-penduduk', \App\Http\Controllers\MutasiPendudukController::class)->middleware('role:Superadmin,Staf');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
