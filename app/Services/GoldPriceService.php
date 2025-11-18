<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\GoldPriceHistory;

class GoldPriceService
{
    protected $cacheKey = 'gold_price_idr';

    /**
     * Ambil harga emas per gram (IDR)
     */
    public function getGoldPrice(): float
    {
        // Cek cache 1 jam
        return Cache::remember($this->cacheKey, now()->addHour(), function () {
            try {
                // Contoh API gratis: metals-api.com (gunakan API key kalau ada)
                // Untuk sementara, pakai placeholder API atau mock
                $response = Http::timeout(5)->get('https://api.metals.live/v1/spot');
                $data = $response->json();

                // Format data kadang kompleks, sesuaikan berdasarkan API
                // Misal [ ['gold', 2345.67], ... ]
                if (is_array($data) && isset($data[0]['gold'])) {
                    // Dapat harga emas USD/oz
                    $priceUsdPerOunce = $data[0]['gold'];
                    $usdToIdr = 16000; // fix sementara, nanti bisa otomatis via API
                    $pricePerGram = ($priceUsdPerOunce / 31.1035) * $usdToIdr;
                    return round($pricePerGram);
                }

                // Jika gagal parse
                return 1200000; // fallback default: Rp 1.200.000 per gram
            } catch (\Throwable $e) {
                // Kalau error jaringan, tetap return default
                return 1200000;
            }
        });
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
