<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DonasiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahan penting

class DonasiController extends Controller
{
    /**
     * Menampilkan halaman laporan donasi dengan filter.
     */
    public function index(Request $request)
    {
        $query = Donasi::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->tanggal_mulai;
            $tanggalAkhir = $request->tanggal_akhir;
            $query->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
        }

        $semuaDonasi = $query->latest()->get();

        return view('admin.donasi.laporan', [
            'daftar_donasi' => $semuaDonasi
        ]);
    }

    /**
     * ======================================================
     * == FUNGSI BARU UNTUK MENANGANI EKSPOR DATA KE EXCEL ==
     * ======================================================
     */
    public function exportExcel(Request $request)
    {
        $namaFile = 'laporan_donasi_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        // Kirim $request ke DonasiExport agar filter tanggal ikut terbawa
        return Excel::download(new DonasiExport($request), $namaFile);
    }
}

