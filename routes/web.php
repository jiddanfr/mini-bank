<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PengaturanAdministrasiController;


// Rute untuk dashboard dan formulir simpanan/penarikan
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Rute untuk Nasabah
Route::prefix('nasabah')->group(function () {
    Route::get('/', [NasabahController::class, 'index'])->name('nasabah.index');
    Route::get('/create', [NasabahController::class, 'create'])->name('nasabah.create');
    Route::post('/', [NasabahController::class, 'store'])->name('nasabah.store');
    Route::get('/{nis}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
    Route::put('/{nis}', [NasabahController::class, 'update'])->name('nasabah.update');
    Route::get('/check-nis/{nis}', [NasabahController::class, 'checkNis']); // Untuk AJAX, tidak perlu nama
    Route::get('/search-nasabah', [NasabahController::class, 'search'])->name('search-nasabah');
});

// Rute untuk simpanan
Route::post('/simpan-simpanan', [SimpananController::class, 'simpanSimpanan'])->name('simpan-simpanan');
Route::get('/simpan-simpanan-cetak', [SimpananController::class, 'simpanSimpananCetak'])->name('simpan-simpanan-cetak');
// Rute untuk penarikan
Route::post('/simpan-penarikan', [PenarikanController::class, 'simpanPenarikan'])->name('simpan-penarikan');
Route::get('/penarikan-cetak', [PenarikanController::class, 'penarikanCetak'])->name('penarikan-cetak');
// Rute untuk aktivitas
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/pdf', [ActivityController::class, 'generatePdf'])->name('activities.generatePdf');

Route::get('/pengaturan', [PengaturanAdministrasiController::class, 'index'])->name('pengaturan.index');
Route::post('/pengaturan/update', [PengaturanAdministrasiController::class, 'update'])->name('pengaturan.update');