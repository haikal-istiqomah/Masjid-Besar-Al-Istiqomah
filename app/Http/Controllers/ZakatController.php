<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZakatController extends Controller
{
    public function index()
    {
        // form kalkulator
        return view('zakat.kalkulator');
    }

    public function hitung(Request $request)
    {
        $data = $request->validate([
            'region'      => 'required|string',
            'jumlah_hari' => 'nullable|integer|min:1',
        ]);

        $param = ZakatParam::where('region', $data['region'])
                  ->where('year', now()->year)
                  ->firstOrFail();

        $fitrahUang = $param->fitrah_qty_kg * $param->rice_price_per_kg;
        $fidyahUang = null;

        if (!empty($data['jumlah_hari'])) {
            $fidyahUang = $param->fidyah_qty_kg * $param->rice_price_per_kg * (int) $data['jumlah_hari'];
        }

        return back()->with([
            'region'      => $data['region'],
            'fitrah_uang' => (int) round($fitrahUang),
            'fidyah_uang' => $fidyahUang ? (int) round($fidyahUang) : null,
        ]);
    }
}
