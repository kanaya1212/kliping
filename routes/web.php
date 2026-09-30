<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KoranController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// ================= REDIRECT =================
Route::get('/', fn () => redirect('/login'));

// ================= AUTH =================
require __DIR__.'/auth.php';

// ================= PROTECTED =================
Route::middleware('auth')->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [BerandaController::class, 'index'])->name('beranda');

    // ================= PROFILE =================
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/profile/edit-form', [ProfileController::class, 'editForm'])
    ->name('profile.form');

//  PASSWORD
Route::get('/profile/password', [ProfileController::class, 'editPassword'])
    ->name('profile.password');

Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.password.update');

    //  TAMBAHAN (WAJIB BIAR TOMBOL PASSWORD JALAN)
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])
        ->name('profile.password');


    // ================= PEGAWAI =================
    Route::middleware('role:pegawai')->group(function () {

        // ================= KORAN =================
        Route::prefix('koran')->group(function () {

            Route::get('/', [KoranController::class, 'index'])->name('koran.index');
            Route::get('/create', [KoranController::class, 'create'])->name('koran.create');
            Route::post('/store', [KoranController::class, 'store'])->name('koran.store');
            Route::get('/edit/{id}', [KoranController::class, 'edit'])->name('koran.edit');
            Route::put('/update/{id}', [KoranController::class, 'update'])->name('koran.update');
            Route::delete('/{id}', [KoranController::class, 'destroy'])->name('koran.destroy');
        });

        // ================= BERITA =================
        Route::prefix('berita')->group(function () {

            Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
            Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
            Route::post('/store', [BeritaController::class, 'store'])->name('berita.store');
            Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
            Route::put('/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
            Route::delete('/delete/{id}', [BeritaController::class, 'destroy'])->name('berita.delete');

            Route::get('/pdf/{id}', [BeritaController::class, 'exportPdf'])
                ->name('berita.export.pdf');
        });

    });

    // ================= SEMUA ROLE =================
    Route::middleware('role:pegawai,kepala_seksi')->group(function () {

        Route::get('/berita/{id}', [BeritaController::class, 'show'])
            ->name('berita.show');

        Route::view('/laporan', 'laporan')->name('laporan');

        Route::get('/laporan/harian', [LaporanController::class, 'harian'])
            ->name('laporan.harian');

        Route::get('/laporan/mingguan', [LaporanController::class, 'mingguan'])
            ->name('laporan.mingguan');

        Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])
            ->name('laporan.bulanan');

        Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])
            ->name('laporan.tahunan');
    });

    // ================= DOWNLOAD =================
    Route::get('/laporan/harian/download/{tanggal}', 
        [LaporanController::class, 'downloadHarian']
    )->name('laporan.harian.download');

    Route::get('/laporan/mingguan/download', 
        [LaporanController::class, 'downloadMingguan']
    )->name('laporan.mingguan.download');

    Route::get('/laporan/bulanan/download', 
        [LaporanController::class, 'downloadBulanan']
    )->name('laporan.bulanan.download');

    Route::get('/laporan/tahunan/download', 
        [LaporanController::class, 'downloadTahunan']
    )->name('laporan.tahunan.download');
});