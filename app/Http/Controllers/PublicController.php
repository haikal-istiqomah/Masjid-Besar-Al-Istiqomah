<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Transaksi;
use App\Models\Donasi;
use Illuminate\Support\Str;

// Tambahkan use statement untuk Midtrans
use Midtrans\Config;
use Midtrans\Snap;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) website.
     */
    public function index()
    {
        $beritas = Berita::latest('tanggal_publikasi')->take(3)->get();
        $totalPemasukan = Transaksi::where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        return view('welcome', compact('beritas', 'saldoAkhir'));
    }

    /**
     * Menampilkan halaman daftar semua berita untuk publik.
     */
    public function berita(Request $request)
    {
        $query = Berita::query();
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $query->orderBy('tanggal_publikasi', $request->input('urutan', 'desc'));
        $semuaBerita = $query->paginate(9)->withQueryString();
        return view('public.berita.index', [
            'semuaBerita' => $semuaBerita
        ]);
    }

    /**
     * Menampilkan halaman detail dari sebuah berita untuk publik.
     */
    public function showBerita(Berita $berita)
    {
        return view('public.berita.show', compact('berita'));
    }

    /**
     * Menampilkan halaman form donasi untuk publik.
     */
    public function showDonasiForm()
    {
        return view('donasi.create');
    }

    /**
     * Memproses donasi, menyimpannya, dan membuat transaksi di Midtrans.
     */
    public function storeDonasi(Request $request)
    {
        // 1. Validasi data dari form, termasuk email
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'email' => 'nullable|email',
            'jumlah' => 'required|numeric|min:10000',
            'pesan' => 'nullable|string',
        ]);

        // 2. Buat record donasi di database kita terlebih dahulu
        $donasi = Donasi::create([
            'order_id' => 'DONASI-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'nama_donatur' => $validated['nama_donatur'],
            'email' => $validated['email'],
            'jumlah' => $validated['jumlah'],
            'pesan' => $validated['pesan'],
            'status' => 'pending', // Status awal donasi
        ]);

        // 3. Konfigurasi Midtrans menggunakan API Keys dari file .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 4. Siapkan parameter yang akan dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $donasi->order_id,
                'gross_amount' => $donasi->jumlah,
            ],
            'customer_details' => [
                'first_name' => $donasi->nama_donatur,
                'email' => $donasi->email,
            ],
        ];

        try {
            // 5. Minta "Snap Token" (token pembayaran) dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 6. Kirim token ke view untuk ditampilkan sebagai pop-up pembayaran
            return view('donasi.pembayaran', compact('snapToken', 'donasi'));
        } catch (\Exception $e) {
            // Jika gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

