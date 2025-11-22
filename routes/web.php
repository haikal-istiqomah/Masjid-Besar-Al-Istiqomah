<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\LaporanKeuanganPublikController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;
use App\Http\Controllers\Admin\GoldPriceController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (PENGUNJUNG)
|--------------------------------------------------------------------------
*/

// Halaman Utama & Berita & Donasi (Menggunakan Group Controller)
Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'index')->name('front.landing');
    Route::view('/layanan', 'front.layanan-lain')->name('front.layanan');
    
    // Berita
    Route::get('/berita', 'berita')->name('front.berita.index');
    Route::get('/berita/{berita:slug}', 'showBerita')->name('front.berita.show');

    // Donasi
    Route::get('/donasi', 'showDonasiForm')->name('donasi.create');
    Route::post('/donasi', 'storeDonasi')->name('donasi.store');
    Route::get('/donasi/cetak/{id}', 'cetak')->name('donasi.cetak');
    Route::get('/donasi/finish', 'finish')->name('midtrans.finish');
});

// Laporan Keuangan Publik
Route::get('/laporan', [LaporanKeuanganPublikController::class, 'index'])
    ->name('front.laporan.index');

// Midtrans Webhook (Wajib bypass CSRF di bootstrap/app.php)
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification')
    ->withoutMiddleware([VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| RUTE ZAKAT (KALKULATOR)
|--------------------------------------------------------------------------
*/
Route::controller(ZakatController::class)->name('zakat.')->group(function () {
    Route::get('/kalkulator-zakat', 'index')->name('index');
    Route::post('/kalkulator-zakat/hitung', 'hitung')->name('hitung');
    Route::post('/zakat/store', 'store')->name('store');
    Route::get('/zakat/store/manual', 'storeManual')->name('store.manual');
    Route::post('/kalkulator-zakat/live', 'liveUpdate')->name('live');
    
    Route::get('/zakat/finish', function (\Illuminate\Http\Request $request) {
        session()->forget(['zakat_hasil', 'zakat_jenis', 'zakat_nominal_perhitungan', 'zakat_input']);
        return view('front.zakat.sukses', ['result' => $request->all()]);
    })->name('finish');
});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.post');
    Route::post('/admin/logout', 'logout')->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,bendahara', 'no.cache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Berita
        Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita']);

        // Laporan Transaksi Keuangan
        Route::resource('transaksi', LaporanKeuanganController::class)->parameters(['transaksi' => 'transaksi']);

        // Laporan Donasi
        Route::controller(AdminDonasiController::class)->prefix('laporan-donasi')->name('donasi.')->group(function() {
            Route::get('/', 'index')->name('laporan');
            Route::get('/export', 'exportExcel')->name('export');
            Route::patch('/{donasi}/status', 'setStatus')->name('set-status');
        });

        // Manajemen Zakat
        Route::controller(\App\Http\Controllers\Admin\ZakatController::class)
            ->prefix('zakat')
            ->name('zakat.')
            ->group(function() {
                Route::get('/', 'index')->name('index');
                Route::get('/export', 'exportExcel')->name('export');
                Route::get('/{zakat}', 'show')->name('show');
                Route::patch('/{zakat}/status', 'updateStatus')->name('update-status');
            });

        // Manajemen Harga Emas
        Route::controller(GoldPriceController::class)->prefix('harga-emas')->name('harga-emas.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/refresh', 'refresh')->name('refresh');
            Route::get('/history', 'history')->name('history');
        });
    });