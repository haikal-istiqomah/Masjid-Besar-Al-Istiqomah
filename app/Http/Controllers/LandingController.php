<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita; // jika ada model berita
use App\Models\Donasi; // jika ada model donasi

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil 6 berita terbaru jika model Berita tersedia, jika tidak, kosongkan
        $beritas = class_exists(Berita::class) ? Berita::latest()->take(6)->get() : collect();

        // Ringkasan donasi singkat (jika ada model Donasi)
        $donasiSummary = [
            'total_terkumpul' => 0,
            'jumlah_transaksi' => 0,
        ];
        if (class_exists(Donasi::class)) {
            $donasiSummary['total_terkumpul'] = Donasi::sum('jumlah') ?? 0;
            $donasiSummary['jumlah_transaksi'] = Donasi::count();
        }

        // Data statis / konfigurasi untuk landing page
        $masjid = [
            'title' => 'Masjid Besar Al-Istiqomah',
            'address' => "Jl. Gerbang Dayaku RT.06, Desa Loa Duri Ilir, Kecamatan Loa Janan, Kabupaten Kutai Kartanegara, Kalimantan Timur, 75391",
            'email' => 'alistiqomah14@gmail.com',
            'phone' => '0822 54589345',
            'instagram' => 'https://www.instagram.com/masjid_besar_al_istiqomah0101',
            'facebook' => 'https://www.facebook.com/share/19PUV8ekbp/',
            'youtube' => 'https://youtube.com/@masjidbesaral-istiqomah6671',
            // Google Maps embed url (iframe src) — kita gunakan shared link
            'maps_embed' => 'https://maps.app.goo.gl/7rbuW8pTqgfT12Ty8',
        ];

        return view('landing', compact('beritas', 'donasiSummary', 'masjid'));
    }
}
