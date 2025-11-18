<?php

// Adalah Controller untuk mengelola riwayat harga emas di panel admin

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldPriceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\GoldPriceService;

class GoldPriceController extends Controller
{
    public function index(GoldPriceService $goldService)
    {
        $harga = $goldService->getGoldPrice();
        $lastUpdated = Cache::get('gold_price_last_update', now());
        return view('admin.harga-emas', compact('harga', 'lastUpdated'));
    }

    public function refresh(GoldPriceService $goldService)
    {
        $hargaBaru = $goldService->refreshGoldPrice();
        Cache::put('gold_price_last_update', now());
        return back()->with('success', 'Harga emas berhasil diperbarui: Rp ' . number_format($hargaBaru, 0, ',', '.'));
    }

    public function history()
    {
        $histories = GoldPriceHistory::latest()->take(30)->get();
        return view('admin.harga-emas-history', compact('histories'));
    }
}
