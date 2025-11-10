<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $q = Donasi::query()->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('payment_type')) {
            $q->where('payment_type', $request->payment_type);
        }

        $daftar_donasi = $q->paginate(20)->withQueryString();

        return view('admin.donasi.laporan', compact('daftar_donasi'));
    }

    public function setStatus(Request $request, Donasi $donasi)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending','success','failed','expired','refunded'])],
        ]);

        // (opsional) batasi manual hanya untuk transfer manual:
        // if ($donasi->payment_type !== 'manual_transfer') {
        //     return back()->with('err', 'Hanya donasi transfer manual yang bisa diubah manual.');
        // }

        $donasi->status = $data['status'];
        $donasi->save();

        return back()->with('ok', 'Status donasi diperbarui.');
    }

    public function sukses(Request $request)
    {
        // Ambil data transaksi dari session atau callback
        $orderId = $request->query('order_id');
        $donasi = Donasi::where('order_id', $orderId)->first();
    
        return view('donasi.sukses', compact('donasi'));
    }

}
