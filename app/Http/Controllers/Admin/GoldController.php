<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoldPriceService;
use Illuminate\Http\Request;

class GoldController extends Controller
{
    protected $goldService;

    public function __construct(GoldPriceService $goldService)
    {
        $this->goldService = $goldService;
    }

    public function index()
    {
        $harga = $this->goldService->getGoldPrice();
        $lastUpdated = now()->subHour()->diffForHumans(); // indikasi cache
        return view('admin.harga-emas', compact('harga', 'lastUpdated'));
    }

    public function refresh()
    {
        $this->goldService->clearCache();
        $hargaBaru = $this->goldService->getGoldPrice();
        return redirect()->route('admin.harga-emas.index')
            ->with('success', "Harga emas berhasil diperbarui: Rp " . number_format($hargaBaru, 0, ',', '.'));
    }
}
