<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;

/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita.publik.index');
Route::get('/berita/{berita:slug}', [PublicController::class, 'showBerita'])->name('berita.publik.show');
Route::get('/donasi', [PublicController::class, 'showDonasiForm'])->name('donasi.create');
Route::post('/donasi', [PublicController::class, 'storeDonasi'])->name('donasi.store');
// --- RUTE PUBLIK ---

// ... rute publik kamu yang lain ...

// Kalkulator Zakat (PUBLIC)
Route::get('/kalkulator-zakat', [ZakatController::class, 'index'])->name('zakat.index');
Route::post('/kalkulator-zakat/hitung', [ZakatController::class, 'hitung'])->name('zakat.hitung');

// Midtrans (PUBLIC)
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
  ->name('midtrans.notification')
  ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/midtrans/finish', [MidtransController::class, 'finish'])
  ->name('midtrans.finish');
/*
|--------------------------------------------------------------------------
| Rute Internal (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GRUP UNTUK SEMUA RUTE ADMIN
    Route::prefix('admin')->name('admin.')->group(function() {

        // PERBAIKAN: Menambahkan ->parameters() untuk menghindari kesalahan nama "beritum"
        Route::resource('berita', BeritaController::class)->parameters([
            'berita' => 'berita'
        ]);
        
        Route::resource('transaksi', TransaksiController::class);

        // Laporan Donasi
        Route::get('laporan-donasi', [AdminDonasiController::class, 'index'])->name('donasi.laporan');
        Route::get('laporan-donasi/export', [AdminDonasiController::class, 'exportExcel'])->name('donasi.export');
        Route::patch('donasi/{donasi}/status', [AdminDonasiController::class, 'setStatus'])
        ->name('donasi.set-status');

    });

    // Rute untuk menerima notifikasi dari Midtrans (Webhook)
    
});

require __DIR__.'/auth.php';