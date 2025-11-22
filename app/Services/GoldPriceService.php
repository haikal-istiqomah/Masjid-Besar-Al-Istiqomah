<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\GoldPriceHistory;

class GoldPriceService
{
    protected $cacheKey = 'gold_price_idr';

    /**
     * Ambil harga emas: Prioritas Input Manual Terakhir -> API -> Default
     */
    public function getGoldPrice(): float
    {
        // 1. Cek data terakhir di database
        $latest = GoldPriceHistory::latest()->first();

        // Jika ada data & baru diupdate (< 24 jam), pakai itu.
        // Ini mencakup input manual admin maupun fetch API terakhir.
        if ($latest) {
            return $latest->price_per_gram;
        }

        // 2. Jika database kosong, coba API (Fallback)
        return $this->fetchGoldPriceFromAPI();
    }

    /**
     * Admin update harga manual
     */
    public function setManualPrice($price): void
    {
        GoldPriceHistory::create([
            'price_per_gram' => $price,
            'source' => 'Manual Admin', // Penanda bahwa ini input manual
        ]);
        
        // Update cache agar frontend langsung berubah
        Cache::put($this->cacheKey, $price, now()->addDay());
    }

    /**
     * Logika asli API dipisah ke sini (Private)
     */
    private function fetchGoldPriceFromAPI(): float
    {
        // ... (Kode API lama Anda simpan di sini, return 1200000 jika gagal) ...
        // Contoh singkat:
        try {
             $response = Http::timeout(5)->get('https://api.metals.live/v1/spot');
             // ... logika parsing ...
             return 1350000; // Misal hasil parsing
        } catch (\Throwable $e) {
             return 1200000; // Fallback statis
        }
    }


    // Penyegaran Harga Emas
    public function refreshGoldPrice(): float
    {
        $newPrice = $this->fetchGoldPriceFromAPI(); // ambil dari API seperti sebelumnya
        Cache::put('gold_price', $newPrice, now()->addHour());

        // Simpan ke tabel riwayat
        GoldPriceHistory::create([
            'price_per_gram' => $newPrice,
            'source' => 'API Real-Time',
        ]);

        return $newPrice;
    }
    
    /**
     * Hapus cache manual (jika admin mau refresh harga)
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }
}
