<?php

namespace App\Http\Controllers;

use App\Models\Zakat;
use App\Services\GoldPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ZakatController extends Controller
{
    public function index(Request $request, GoldPriceService $gold)
    {
        $regions = [];
        $goldPriceInit = $gold->getGoldPrice();

        // Reset session jika bukan hasil redirect
        if (!$request->session()->has('zakat_hasil') && !$request->has('keep')) {
            session()->forget([
                'zakat_hasil', 'zakat_jenis', 'zakat_nominal_perhitungan',
                'zakat_input', 'zakat_status', 'zakat_nisab', 'zakat_dasar_nisab'
            ]);
            session()->forget('success');
        }

        return view('front.zakat.kalkulator', [
            'regions' => $regions,
            'goldPriceInit' => $goldPriceInit,
        ]);
    }

    // ================================
    // HITUNG ZAKAT
    // ================================
    public function hitung(Request $request, GoldPriceService $goldService)
    {
        $request->validate([
            'jenis' => 'required|in:profesi,maal,perniagaan',
        ]);

        $jenis = $request->jenis;
        $hasil = 0;
        $status = 'Belum wajib zakat';
        $nominal_perhitungan = 0;
        $hargaEmasPerGram = $goldService->getGoldPrice();
        $nisab = 0;
        $dasar = '';
        $total = 0;
        $metode = 'emas';

        // ========================
        // ZAKAT PROFESI
        // ========================
        if ($jenis === 'profesi') {

            $metode = $request->input('nisab_metode', 'emas');
            $hargaBerasPerKg = (float) str_replace('.', '',
                $request->input('harga_beras', session('zakat_input.harga_beras', 15000))
            );

            session()->put('zakat_input.harga_beras', $hargaBerasPerKg);

            if ($metode === 'emas') {
                $nisab = (85 * $hargaEmasPerGram) / 12;
                $dasar = "Nisab emas 85 gr (Rp " . number_format($hargaEmasPerGram, 0, ',', '.') . "/gr per bulan)";
            } else {
                $nisab = $hargaBerasPerKg * 522;
                $dasar = "Nisab beras 522 kg (Rp " . number_format($hargaBerasPerKg, 0, ',', '.') . "/kg per tahun)";
            }

            $penghasilan = (float) str_replace('.', '', $request->input('penghasilan', 0));
            $tambahan = (float) str_replace('.', '', $request->input('tambahan', 0));
            $pengeluaran = (float) str_replace('.', '', $request->input('pengeluaran', 0));
            $bulan = (int) $request->input('bulan', 1);

            $total = ($penghasilan + $tambahan - $pengeluaran) * $bulan;

            if ($total >= $nisab) {
                $nominal_perhitungan = round($total * 0.025);
                $status = 'Wajib zakat';
            }

            $hasil = $nominal_perhitungan;
        }

        // ========================
        // ZAKAT MAAL
        // ========================
        elseif ($jenis === 'maal') {

            $harta = (float) str_replace('.', '', $request->input('harta', 0));
            $uang = (float) str_replace('.', '', $request->input('uang', 0));
            $lainnya = (float) str_replace('.', '', $request->input('lainnya', 0));
            $hutang = (float) str_replace('.', '', $request->input('hutang', 0));

            $total = $harta + $uang + $lainnya - $hutang;
            $nisab = 85 * $hargaEmasPerGram;
            $dasar = "Nisab emas 85 gr (Rp " . number_format($hargaEmasPerGram, 0, ',', '.') . "/gr per tahun)";

            if ($total >= $nisab) {
                $nominal_perhitungan = round($total * 0.025);
                $status = 'Wajib zakat';
            }

            $hasil = $nominal_perhitungan;
        }

        // ========================
        // ZAKAT PERNIAGAAN
        // ========================
        elseif ($jenis === 'perniagaan') {

            $modal = (float) str_replace('.', '', $request->input('modal', 0));
            $pendapatan = (float) str_replace('.', '', $request->input('pendapatan', 0));
            $piutang = (float) str_replace('.', '', $request->input('piutang', 0));
            $barang = (float) str_replace('.', '', $request->input('barang', 0));
            $hutang = (float) str_replace('.', '', $request->input('hutang', 0));
            $pengeluaran = (float) str_replace('.', '', $request->input('pengeluaran', 0));

            $total = $modal + $pendapatan + $piutang + $barang - $hutang - $pengeluaran;
            $nisab = 85 * $hargaEmasPerGram;
            $dasar = "Nisab emas 85 gr (Rp " . number_format($hargaEmasPerGram, 0, ',', '.') . "/gr per tahun)";

            if ($total >= $nisab) {
                $nominal_perhitungan = round($total * 0.025);
                $status = 'Wajib zakat';
            }

            $hasil = $nominal_perhitungan;
        }

        // =================================
        // SIMPAN SESSION
        // =================================
        session([
            'zakat_hasil' => $hasil,
            'zakat_jenis' => $jenis,
            'zakat_total_harta' => $total,
            'zakat_status' => $status,
            'zakat_nisab' => $nisab,
            'zakat_harga_emas' => $hargaEmasPerGram,
            'zakat_metode_nisab' => $metode,
            'zakat_dasar_nisab' => $dasar,
            'zakat_nominal_perhitungan' => $nominal_perhitungan,
            'zakat_input' => $request->all(),
        ]);

        return redirect()->route('zakat.index', ['keep' => 1])
            ->with('success', 'Perhitungan zakat selesai.');
    }

    // ================================
    // FUNGSI STORE 
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:profesi,maal,perniagaan',
            'jumlah' => 'required|numeric|min:1000',
            'nama' => 'nullable|string|max:255',
            'email' => 'nullable|email',
        ]);

        $namaMuzakki = $request->nama ?: 'Hamba Allah';

        $orderId = 'ZAKAT-' . strtoupper($request->jenis) . '-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

        $zakat = Zakat::create([
            'order_id' => $orderId,
            'nama' => $namaMuzakki,
            'email' => $request->email,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'nominal_perhitungan' => $request->nominal_perhitungan,
            'status' => 'pending',
        ]);
        
        $midtrans = new \App\Http\Controllers\MidtransController;
        
        $snapToken = $midtrans->createSnapTokenForOrder(
            $orderId,
             $zakat->jumlah,
             $zakat->nama,
             $zakat->email
        );

        $zakat->update(['midtrans_response' => ['snap_token' => $snapToken]]);

        session()->forget([
            'zakat_hasil', 'zakat_jenis', 'zakat_nominal_perhitungan', 'zakat_input'
        ]);

        return view('front.zakat.pembayaran', compact('zakat', 'snapToken'));
    }

    // ================================
    // STORE MANUAL Saya Punya Perhitungan Sendiri
    // ================================
    public function storeManual(Request $request)
    {
        $jenis = session('zakat_jenis');
        $jumlah = session('zakat_hasil');
        $nama = session('zakat_input.nama');
        $email = session('zakat_input.email');

        $zakat = Zakat::create([
            'jenis' => $jenis,
            'jumlah' => $jumlah,
            'status' => 'pending',
            'nama' => $nama,
            'email' => $email,
            'order_id' => 'ZAKAT-' . strtoupper($jenis) . '-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
        ]);

        $midtrans = new \App\Http\Controllers\MidtransController();
        $snapToken = $midtrans->createSnapTokenForOrder(
            $zakat->order_id, $zakat->jumlah, $zakat->nama, $zakat->email
        );

        $zakat->update(['snap_token' => $snapToken]);

        session()->forget([
            'zakat_hasil', 'zakat_jenis', 'zakat_nominal_perhitungan', 'zakat_input'
        ]);

        return view('front.zakat.pembayaran', compact('zakat', 'snapToken'));
    }

    // ================================
    // LIVE UPDATE Total Bayar
    // ================================
    public function liveUpdate(Request $request)
    {
        foreach (['profesi', 'maal', 'perniagaan', 'total'] as $key) {
            if ($request->has($key)) {
                session(["zakat_live.$key" => $request->$key]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function cetak($id)
    {
        $zakat = Zakat::findOrFail($id);
        
        // Hanya bisa cetak jika sudah Lunas
        if ($zakat->status != 'paid') {
            return back()->with('error', 'Bukti hanya dapat dicetak untuk transaksi lunas.');
        }

        $pdf = Pdf::loadView('front.zakat.bukti', compact('zakat'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('Bukti-Zakat-'.$zakat->order_id.'.pdf');
    }
}
