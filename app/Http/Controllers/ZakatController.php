<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZakatRequest;
use App\Models\ZakatParam;

class ZakatController extends Controller
{
    public function index()
    {
         $regions = \App\Models\ZakatParam::where('year', now()->year)
                ->orderBy('region')
                ->pluck('region')
                ->unique()
                ->values();

    return view('zakat.kalkulator', compact('regions'));
    }

    public function hitung(ZakatRequest $request)
    {
        $data = $request->validated();

        $param = ZakatParam::regionYear($data['region'], now()->year)->first();

        if (!$param) {
            return back()
                ->withErrors(['region' => 'Parameter zakat untuk wilayah & tahun ini belum tersedia.'])
                ->withInput();
        }

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
