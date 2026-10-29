<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JimpitanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:6,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Admin dan petugas
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/scan', [ScannerController::class, 'index'])->name('scan');
    Route::get('/catat', [JimpitanController::class, 'create'])->name('jimpitan.create');
    Route::post('/catat', [JimpitanController::class, 'store'])->name('jimpitan.store');
    Route::get('/riwayat', [JimpitanController::class, 'index'])->name('jimpitan.index');
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('/rekap', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/lainnya', [PengaturanController::class, 'index'])->name('lainnya');

    // Khusus admin (dicek di server, bukan hanya disembunyikan di tampilan)
    Route::middleware('role:admin')->group(function () {
        Route::get('/warga/tambah', [WargaController::class, 'create'])->name('warga.create');
        Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
        Route::get('/warga/cetak', [WargaController::class, 'cetak'])->name('warga.cetak');
        Route::get('/warga/{warga}', [WargaController::class, 'show'])->name('warga.show');
        Route::get('/warga/{warga}/ubah', [WargaController::class, 'edit'])->name('warga.edit');
        Route::put('/warga/{warga}', [WargaController::class, 'update'])->name('warga.update');
        Route::patch('/warga/{warga}/status', [WargaController::class, 'status'])->name('warga.status');

        Route::post('/riwayat/{jimpitan}/batal', [JimpitanController::class, 'batal'])->name('jimpitan.batal');

        Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::get('/petugas', [PengaturanController::class, 'petugas'])->name('petugas.index');
        Route::post('/petugas', [PengaturanController::class, 'simpanPetugas'])->name('petugas.store');
        Route::patch('/petugas/{user}/status', [PengaturanController::class, 'statusPetugas'])->name('petugas.status');
    });
});
