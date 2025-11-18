<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Transaksi;
use App\Models\Donasi;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


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
        return view('landing', compact('beritas', 'saldoAkhir'));
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
    public function showDonasiForm(Request $request)
    {
        if ($request->boolean('new')) {
        session()->forget(['snap_token', 'order_id', 'success']);
        }
        return view('donasi.create');
    }

    /**
     * Memproses donasi, menyimpannya, dan membuat transaksi di Midtrans.
     */
    public function storeDonasi(Request $request)
    {
        // 1. Validasi data dari form, termasuk email
        $validated = $request->validate([
            'nama_donatur'  => 'required|string|max:255',
            'email'         => 'nullable|email',
            'jumlah'        => 'required|numeric|min:10000',
            'pesan'         => 'nullable|string',
        ]);

        // 2. Buat record donasi di database kita terlebih dahulu
        $donasi = Donasi::create([
            'order_id' => 'DONASI-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'nama_donatur' => $validated['nama_donatur'],
            'email' => $validated['email'] ?? null, 
            'jumlah' => $validated['jumlah'],
            'pesan' => $validated['pesan'] ?? null,
            'status' => 'pending', // Status awal donasi
            'payment_type' => null, // Filled from Webhok Midtrans
        ]);

        // 3. Konfigurasi Midtrans menggunakan API Keys dari file .env
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // 4. Siapkan parameter yang akan dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $donasi->order_id,
                'gross_amount' => (int) $donasi->jumlah,
            ],
            'customer_details' => [
                'first_name' => $donasi->nama_donatur,
                'email'      => $donasi->email,
            ],
            'enabled_payments' => [
            // e-wallet & kartu
            'credit_card', 'gopay', 'shopeepay', 'qris',
            // VA & Mandiri Bill
            'bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'permata_va', 'other_va', 'echannel',
            // Minimarket
            'indomaret', 'alfamart',
            ],
            // (opsional) atur kadaluarsa VA/invoice
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit'       => 'days',     // 'minutes' | 'hours' | 'days'
                'duration'   => 1,
            ],

            // (opsional) pakai Finish URL dari .env
            'callbacks' => [
                'finish' => config('services.midtrans.finish_url'),  // MIDTRANS_FINISH_URL
            ],

            // 'item_details' => (opsional) customer_details/item_details
        ];

        try {
            // 5. Minta "Snap Token" (token pembayaran) dari Midtrans
            $snapToken = Snap::getSnapToken($params);

           // 6) Kembali ke form, trigger popup via session('snap_token')
            return redirect()
                ->route('donasi.create')
                ->with('order_id', $donasi->order_id)
                ->with('success', 'Donasi berhasil dibuat. Silakan selesaikan pembayaran.')
                ->with('snap_token', $snapToken);
        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withErrors('Gagal membuat transaksi: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan halaman "finish" (terima kasih) setelah redirect dari Midtrans.
     */
    public function finish(Request $request)
    {
        // Ambil order_id dari URL (dikirim Midtrans setelah transaksi)
        $orderId = $request->query('order_id');

        // Cari data donasi berdasarkan order_id
        $donasi = \App\Models\Donasi::where('order_id', $orderId)->first();

        // Jika data tidak ditemukan, kembalikan ke halaman donasi
        if (!$donasi) {
            return redirect()->route('donasi.create')
                ->with('error', 'Data donasi tidak ditemukan atau belum diproses.');
        }

        // Tambahkan pesan flash
        session()->flash('success', 'Terima kasih! Donasi Anda telah berhasil diproses.');

        // Kirim data ke view sukses.blade.php
        return view('donasi.sukses', compact('donasi'));
    }

    /**
     * Mencetak struk donasi dalam format PDF.
     */
    public function cetak($id)
    {
        $donasi = \App\Models\Donasi::findOrFail($id);

        $pdf = Pdf::loadView('donasi.bukti', compact('donasi'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('Bukti-Donasi-'.$donasi->order_id.'.pdf');
    }

}