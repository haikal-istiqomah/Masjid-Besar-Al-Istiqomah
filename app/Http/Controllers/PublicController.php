<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Transaksi;
use App\Models\Donasi;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama (Landing Page).
     */
    public function index()
    {
        // 1. Ambil Berita Terbaru (Slider & List)
        $beritas = Berita::latest('tanggal_publikasi')->take(6)->get();

        // 2. Hitung Saldo Akhir Keuangan
        $totalPemasukan = Transaksi::where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // 3. Ringkasan Donasi
        $donasiSummary = [
            'total_terkumpul' => Donasi::where('status', 'success')->sum('jumlah'),
            'jumlah_transaksi' => Donasi::where('status', 'success')->count(),
        ];

        // 4. Data Statis Masjid (Konfigurasi)
        $masjid = [
            'title' => 'Masjid Besar Al-Istiqomah',
            'address' => "Jl. Gerbang Dayaku RT.06, Desa Loa Duri Ilir, Kecamatan Loa Janan, Kabupaten Kutai Kartanegara, Kalimantan Timur, 75391",
            'email' => 'alistiqomah14@gmail.com',
            'phone' => '0822 54589345',
            'instagram' => 'https://www.instagram.com/masjid_besar_al_istiqomah0101',
            'facebook' => 'https://www.facebook.com/share/19PUV8ekbp/',
            'youtube' => 'https://youtube.com/@masjidbesaral-istiqomah6671',
        ];

        return view('front.landing', compact('beritas', 'saldoAkhir', 'donasiSummary', 'masjid'));
    }

    /**
     * Menampilkan halaman daftar semua berita.
     */
    public function berita(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $query->orderBy('tanggal_publikasi', $request->input('urutan', 'desc'));
        
        $semuaBerita = $query->paginate(9)->withQueryString();

        return view('front.berita.index', [
            'semuaBerita' => $semuaBerita
        ]);
    }

    /**
     * Menampilkan detail berita.
     */
    public function showBerita(Berita $berita)
    {
        return view('front.berita.show', compact('berita'));
    }

    /**
     * Form Donasi.
     */
    public function showDonasiForm(Request $request)
    {
        if ($request->boolean('new')) {
            session()->forget(['snap_token', 'order_id', 'success']);
        }
        return view('front.donasi.create');
    }

    /**
     * Proses Simpan Donasi & Midtrans.
     */
    public function storeDonasi(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur'  => 'required|string|max:255',
            'email'         => 'nullable|email',
            'jumlah'        => 'required|numeric|min:10000',
            'pesan'         => 'nullable|string',
        ]);

        $donasi = Donasi::create([
            'order_id' => 'DONASI-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'nama_donatur' => $validated['nama_donatur'],
            'email' => $validated['email'] ?? null,
            'jumlah' => $validated['jumlah'],
            'pesan' => $validated['pesan'] ?? null,
            'status' => 'pending',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $donasi->order_id,
                'gross_amount' => (int) $donasi->jumlah,
            ],
            'customer_details' => [
                'first_name' => $donasi->nama_donatur,
                'email'      => $donasi->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            return redirect()
                ->route('donasi.create')
                ->with('order_id', $donasi->order_id)
                ->with('success', 'Donasi berhasil dibuat. Silakan selesaikan pembayaran.')
                ->with('snap_token', $snapToken);

        } catch (\Throwable $e) {
            return back()
                ->withErrors('Gagal membuat transaksi: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Halaman Finish setelah bayar.
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $donasi = Donasi::where('order_id', $orderId)->first();

        if (!$donasi) {
            return redirect()->route('donasi.create')
                ->with('error', 'Data donasi tidak ditemukan.');
        }

        session()->flash('success', 'Terima kasih! Transaksi sedang diproses.');
        return view('front.donasi.sukses', compact('donasi'));
    }

    /**
     * Cetak PDF Bukti Donasi.
     */
    public function cetak($id)
    {
        $donasi = Donasi::findOrFail($id);
        $pdf = Pdf::loadView('front.donasi.bukti', compact('donasi'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('Bukti-Donasi-'.$donasi->order_id.'.pdf');
    }
}