<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Zakat;
use App\Models\Transaksi;
use App\Services\GoldPriceService; // Pastikan service ini di-import

class AdminDashboardController extends Controller
{
    public function index(GoldPriceService $goldService)
    {
        // 1. Hitung Total Donasi (Status 'success')
        $totalDonasi = Donasi::where('status', 'success')->sum('jumlah');

        // 2. Hitung Total Zakat (Status 'paid')
        $totalZakat = Zakat::where('status', 'paid')->sum('jumlah');
        
        // 3. Hitung Keuangan Operasional (Pemasukan - Pengeluaran dari tabel transaksis)
        $pemasukanOps = Transaksi::where('jenis', 'Pemasukan')->sum('jumlah');
        $pengeluaranOps = Transaksi::where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldoOps = $pemasukanOps - $pengeluaranOps;

        // 4. Harga Emas (Menggunakan Service yang sudah ada)
        $hargaEmas = $goldService->getGoldPrice();

        return view('admin.dashboard', compact('totalDonasi', 'totalZakat', 'saldoOps', 'hargaEmas'));
    }
}