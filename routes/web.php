<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LaporanKeuanganPublikController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\Admin\GoldController;
use App\Http\Controllers\Admin\GoldPriceController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('home');

/*
********LAPORAN KEUANGAN PUBLIK********
*/
Route::get('/laporan', [LaporanKeuanganPublikController::class, 'index'])
    ->name('laporan.index');

/*
*******Berita Publik**************************************************************************
*/ 
Route::get('/berita', [PublicController::class, 'berita'])
    ->name('berita.publik.index');

Route::get('/berita/{berita:slug}', [PublicController::class, 'showBerita'])
    ->name('berita.publik.show');

/*
*******DONASI*********************************************************************************
*/

Route::get('/donasi', [PublicController::class, 'showDonasiForm'])->name('donasi.create');
Route::post('/donasi', [PublicController::class, 'storeDonasi'])->name('donasi.store');

Route::get('/donasi/cetak/{id}', [PublicController::class, 'cetak'])
    ->name('donasi.cetak');

Route::get('/donasi/finish', [PublicController::class, 'finish'])
    ->name('midtrans.finish');

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification')
    ->withoutMiddleware([VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| KALKULATOR ZAKAT
|--------------------------------------------------------------------------
*/

Route::get('/kalkulator-zakat', [ZakatController::class, 'index'])
    ->name('zakat.index');

Route::post('/kalkulator-zakat/hitung', [ZakatController::class, 'hitung'])
    ->name('zakat.hitung');

Route::post('/zakat/store', [ZakatController::class, 'store'])
    ->name('zakat.store');

Route::get('/zakat/store/manual', [ZakatController::class, 'storeManual'])
    ->name('zakat.store.manual');

Route::get('/zakat/finish', function (\Illuminate\Http\Request $request) {
    session()->forget(['zakat_hasil', 'zakat_jenis', 'zakat_nominal_perhitungan', 'zakat_input']);
    return view('zakat.sukses', ['result' => $request->all()]);
})->name('zakat.finish');

/*
|--------------------------------------------------------------------------
| LIVE UPDATE ENDPOINT
|--------------------------------------------------------------------------
*/

Route::post('/kalkulator-zakat/live', [ZakatController::class, 'liveUpdate'])
    ->name('zakat.live');


/*
|--------------------------------------------------------------------------
| ADMIN Login
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])
    ->name('admin.logout');



/*
 * ADMIN PANEL (Auth + Role admin/bendahara)
 */
Route::middleware(['auth', 'role:admin,bendahara', 'no.cache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Berita
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita']);

        // Transaksi Keuangan
        Route::resource('transaksi', LaporanKeuanganController::class);

        // Laporan Donasi
        Route::get('laporan-donasi', [AdminDonasiController::class, 'index'])->name('donasi.laporan');
        Route::get('laporan-donasi/export', [AdminDonasiController::class, 'exportExcel'])->name('donasi.export');
        Route::patch('donasi/{donasi}/status', [AdminDonasiController::class, 'setStatus'])->name('donasi.set-status');

        // Harga emas
        Route::get('/harga-emas', [GoldPriceController::class, 'index'])->name('harga-emas.index');
        Route::post('/harga-emas/refresh', [GoldPriceController::class, 'refresh'])->name('harga-emas.refresh');
        Route::get('/harga-emas/history', [GoldPriceController::class, 'history'])->name('harga-emas.history');
    });

//require __DIR__.'/auth.php';
