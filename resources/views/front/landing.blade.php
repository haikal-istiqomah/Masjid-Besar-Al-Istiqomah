@extends('layouts.public')

@section('title', 'Beranda - Masjid Besar Al-Istiqomah')

@section('content')

{{-- HERO SECTION --}}
<div class="relative bg-green-900 overflow-hidden">
    {{-- Gambar Background --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/landing/slide1.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Masjid Background">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-900/90"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="md:w-3/4 lg:w-2/3">
            <span class="inline-block py-1 px-3 rounded-full bg-green-800/50 border border-green-600 text-green-200 text-sm font-semibold mb-4 backdrop-blur-sm">
                Selamat Datang di Website Resmi
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                <span class="text-yellow-400">{{ $masjid['title'] ?? 'Al-Istiqomah' }}</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed max-w-2xl">
                Pusat peribadatan dan pemberdayaan umat. Mari makmurkan masjid dengan sholat berjamaah, zakat, infaq, dan kegiatan sosial.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('donasi.create') }}" class="px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-green-900 font-bold rounded-full shadow-lg transition transform hover:scale-105 text-center">
                    Infaq & Sedekah
                </a>
                <a href="{{ route('zakat.index') }}" class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 hover:bg-white/20 text-white font-semibold rounded-full transition text-center">
                    Kalkulator Zakat
                </a>
            </div>
        </div>
    </div>
</div>

{{-- KONTEN UTAMA (Overlap ke atas) --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KARTU WAKTU SHOLAT --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 border-t-4 border-green-600">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-xl text-gray-800 flex items-center gap-2">
                    Jadwal Sholat
                </h3>
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-mono" id="hijri-date">...</span>
            </div>
            
            <div id="prayer-times-list" class="space-y-2">
                {{-- Skeleton Loading --}}
                <div class="animate-pulse space-y-2">
                    <div class="h-8 bg-gray-100 rounded"></div>
                    <div class="h-8 bg-gray-100 rounded"></div>
                    <div class="h-8 bg-gray-100 rounded"></div>
                </div>
            </div>
            
            <div class="mt-4 text-center border-t pt-3">
                <p class="text-xs text-gray-400 flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span id="location-name">Mendeteksi Lokasi...</span>
                </p>
            </div>
        </div>

        {{-- KARTU DONASI CEPAT --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h3 class="font-bold text-2xl text-gray-800">Donasi Cepat</h3>
                    <p class="text-gray-500 text-sm">Salurkan infaq terbaik Anda sekarang.</p>
                </div>
                <div class="mt-4 md:mt-0 text-right bg-green-50 p-3 rounded-lg border border-green-100">
                    <p class="text-xs text-gray-500 uppercase font-semibold">Total Terkumpul</p>
                    <p class="text-2xl font-bold text-green-700">Rp {{ number_format($donasiSummary['total_terkumpul'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Perhatikan route('donasi.store') TANPA front --}}
            <form id="quick-donate-form" action="{{ route('donasi.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf
                <input type="hidden" name="pesan" value="Donasi Cepat via Website">
                
                <div class="md:col-span-4">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Nama</label>
                    <input name="nama_donatur" class="w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500" placeholder="Hamba Allah">
                </div>
                <div class="md:col-span-5">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Nominal</label>
                    <select name="jumlah" class="w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 font-semibold text-gray-700">
                        <option value="10000">Rp 10.000</option>
                        <option value="20000">Rp 20.000</option>
                        <option value="50000">Rp 50.000</option>
                        <option value="100000" selected>Rp 100.000</option>
                        <option value="500000">Rp 500.000</option>
                    </select>
                </div>
                <div class="md:col-span-3 flex items-end">
                    <button type="submit" class="w-full py-2.5 bg-yellow-500 hover:bg-yellow-600 text-green-900 font-bold rounded-lg transition shadow hover:shadow-md">
                        Lanjut Bayar &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- BERITA SECTION --}}
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Kabar Masjid</h2>
                <div class="h-1 w-20 bg-green-500 mt-2 rounded"></div>
            </div>
            <a href="{{ route('front.berita.index') }}" class="text-green-600 font-semibold hover:text-green-800 text-sm flex items-center gap-1">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($beritas as $b)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col h-full group">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        <img src="{{ $b->gambar ? asset('storage/' . $b->gambar) : 'https://placehold.co/600x400/e2e8f0/1f2937?text=No+Image' }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $b->judul }}">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-800 shadow">
                            {{ ucfirst($b->kategori) }}
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                            <span>📅</span> {{ $b->created_at->format('d F Y') }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-green-600 transition">
                            <a href="{{ route('front.berita.show', $b->slug) }}">{{ $b->judul }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-1">
                            {{ Str::limit(strip_tags($b->isi), 100) }}
                        </p>
                        <a href="{{ route('front.berita.show', $b->slug) }}" class="inline-block text-green-600 font-semibold text-sm hover:underline mt-auto">
                            Baca Selengkapnya
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-4xl mb-2">📭</div>
                    <p class="text-gray-500">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- LOGIKA JADWAL SHOLAT (FIX KOORDINAT) ---
    const prayerContainer = document.getElementById('prayer-times-list');
    const hijriContainer = document.getElementById('hijri-date');
    const locationContainer = document.getElementById('location-name');

    // Koordinat Loa Janan / Samarinda (Akurat)
    const lat = -0.5875; 
    const long = 117.0936; 
    
    // Gunakan Method 20 (Kemenag RI)
    const apiUrl = `https://api.aladhan.com/v1/timings/${Math.floor(Date.now() / 1000)}?latitude=${lat}&longitude=${long}&method=20`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const times = data.data.timings;
            const date = data.data.date;
            
            // Update Tanggal & Lokasi
            hijriContainer.textContent = `${date.hijri.day} ${date.hijri.month.en} ${date.hijri.year}`;
            locationContainer.textContent = "Kutai Kartanegara (Kemenag RI)";

            // List Sholat yang ditampilkan
            const prayers = [
                { key: 'Fajr', label: 'Subuh' },
                { key: 'Sunrise', label: 'Terbit' }, // Opsional
                { key: 'Dhuhr', label: 'Dzuhur' },
                { key: 'Asr', label: 'Ashar' },
                { key: 'Maghrib', label: 'Maghrib' },
                { key: 'Isha', label: 'Isya' }
            ];

            let html = '';
            prayers.forEach(p => {
                html += `
                    <div class="flex justify-between items-center p-2 hover:bg-green-50 rounded border-b border-gray-100 last:border-0 transition cursor-default">
                        <span class="text-gray-600 font-medium">${p.label}</span>
                        <span class="font-bold text-green-700 font-mono text-lg">${times[p.key]}</span>
                    </div>
                `;
            });
            prayerContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('API Error:', error);
            prayerContainer.innerHTML = `<div class="text-center text-red-500 text-sm py-4">Gagal memuat jadwal.</div>`;
        });
});
</script>
@endsection