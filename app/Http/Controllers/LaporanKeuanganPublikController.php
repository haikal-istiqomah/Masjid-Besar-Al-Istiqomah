<?php

namespace App\Http\Controllers;

use App\Models\Transaksi; // <-- 1. Ambil model Transaksi
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanKeuanganPublikController extends Controller
{
    /**
     * Menampilkan halaman laporan keuangan publik.
     */
    public function index(Request $request)
    {
        // 2. Ambil tanggal dari input atau set default ke bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 3. Query awal untuk mengambil transaksi
        $query = Transaksi::query()
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        // Ambil data transaksi yang sudah difilter
        $transaksis = $query->latest()->get();

        // 4. Kalkulasi tetap sama, tapi berdasarkan data yang sudah difilter
        $pemasukan = $transaksis->where('jenis', 'Pemasukan')->sum('jumlah');
        $pengeluaran = $transaksis->where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        // 5. Kirim semua data, TERMASUK tanggal filter, ke view
        return view('front.laporan.index', [
            'transaksis' => $transaksis,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $saldo,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}