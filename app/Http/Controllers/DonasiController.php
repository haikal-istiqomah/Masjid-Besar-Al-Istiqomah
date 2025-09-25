<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donasi; // <-- PENTING: Import model Donasi

class DonasiController extends Controller
{
    /**
     * Menyimpan data donasi baru dari form.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:10000', // Sesuai form, minimal 10.000
            'pesan' => 'nullable|string',
        ]);

        // 2. Buat record baru di database
        Donasi::create([
           'order_id'    => 'DONASI-' . uniqid(),
           'nama_donatur'=> $request->nama_donatur,
           'jumlah'      => $request->jumlah,
           'pesan'       => $request->pesan,
           'status'      => 'Pending', // <— ganti dari 'unpaid' // Status awal, karena belum dibayar
        ]);

        // 3. Arahkan kembali ke halaman utama dengan pesan sukses
        // (Nantinya, ini akan diarahkan ke halaman pembayaran)
        return redirect('/')->with('success', 'Data donasi Anda telah kami terima. Silakan lanjutkan pembayaran.');
    }
}