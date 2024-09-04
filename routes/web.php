<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\AmbilDataNasabahController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PengaturanAdministrasiController;
use App\Http\Controllers\RekapanController;
use App\Http\Controllers\RiwayatRekapanController;

// Rute untuk dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rute untuk Nasabah
Route::prefix('nasabah')->group(function () {
    Route::get('/', [NasabahController::class, 'index'])->name('nasabah.index');
    Route::get('/create', [NasabahController::class, 'create'])->name('nasabah.create');
    Route::post('/', [NasabahController::class, 'store'])->name('nasabah.store');
    Route::get('/{nis}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
    Route::put('/{nis}', [NasabahController::class, 'update'])->name('nasabah.update');
    Route::delete('/{nis}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');
    Route::get('/check-nis/{nis}', [NasabahController::class, 'checkNis']);
    Route::get('/search-nasabah', [NasabahController::class, 'search'])->name('nasabah.search');
    Route::post('/import', [NasabahController::class, 'import'])->name('nasabah.import');
});

// Rute untuk simpanan
Route::post('/simpan-simpanan', [SimpananController::class, 'simpanSimpanan'])->name('simpan-simpanan');
Route::post('/ambil-data-nasabah', [AmbilDataNasabahController::class, 'ambilDataNasabah'])->name('ambil-data-nasabah');

// Rute untuk penarikan
Route::post('/simpan-penarikan', [PenarikanController::class, 'simpanPenarikan'])->name('simpan-penarikan');

// Rute untuk aktivitas
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/pdf', [ActivityController::class, 'generatePdf'])->name('activities.generatePdf');

// Rute untuk pengaturan administrasi
Route::get('/pengaturan', [PengaturanAdministrasiController::class, 'index'])->name('pengaturan.index');
Route::put('/pengaturan/update', [PengaturanAdministrasiController::class, 'update'])->name('pengaturan.update');

// Rute untuk rekapan
Route::get('/rekapan', [RekapanController::class, 'index'])->name('rekapan.index');
Route::get('/rekapan/export', [RekapanController::class, 'export'])->name('rekapan.export');
Route::get('/rekapan/aktivitas/{nis}', [RekapanController::class, 'getAktivitas']);
Route::post('/rekapan/store-yearly', [RekapanController::class, 'storeYearlyRekapan'])->name('rekapan.storeYearly');

// Rute untuk riwayat rekapan
Route::get('/riwayat-rekapan', [RiwayatRekapanController::class, 'index'])->name('riwayat_rekapan.index');
