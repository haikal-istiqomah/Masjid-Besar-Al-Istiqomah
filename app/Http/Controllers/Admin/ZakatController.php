<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zakat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; //library untuk export excel
use App\Exports\ZakatExport;

class ZakatController extends Controller
{
    public function index(Request $request)
    {
        $query = Zakat::latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter jenis zakat
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $zakats = $query->paginate(10)->withQueryString();

        return view('admin.zakat.index', compact('zakats'));
    }

    public function show(Zakat $zakat)
    {
        return view('admin.zakat.show', compact('zakat'));
    }
    
    // Fitur update status manual jika diperlukan (misal bayar tunai)
    public function updateStatus(Request $request, Zakat $zakat)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        $zakat->update(['status' => $request->status]);

        return back()->with('success', 'Status zakat berhasil diperbarui.');
    }

    // Export data zakat ke Excel
    public function exportExcel(Request $request)
    {
        $namaFile = 'Laporan-Zakat-' . now()->format('Y-m-d-His') . '.xlsx';
        return Excel::download(new ZakatExport($request), $namaFile);
    }
}