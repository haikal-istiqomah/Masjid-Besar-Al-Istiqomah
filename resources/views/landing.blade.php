{{-- resources/views/landing.blade.php --}}
@extends('layouts.public')

@section('title', 'Beranda - Masjid Besar Al-Istiqomah')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  {{-- HERO --}}
  <section class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="relative">
        <!-- Slider/hero area -->
        <div id="hero-slider" class="relative h-64 sm:h-96 overflow-hidden">
          <!-- slides (replace src with your images) -->
          <div class="slide absolute inset-0 bg-cover bg-center transition-opacity duration-700 opacity-100" style="background-image:url('/images/landing/slide1.jpg')"></div>
          <div class="slide absolute inset-0 bg-cover bg-center transition-opacity duration-700 opacity-0" style="background-image:url('/images/landing/slide2.jpg')"></div>
          <div class="slide absolute inset-0 bg-cover bg-center transition-opacity duration-700 opacity-0" style="background-image:url('/images/landing/slide3.jpg')"></div>

          <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
            <div class="text-center text-white px-4">
              <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">Selamat Datang di {{ $masjid['title'] }}</h1>
              <p class="mt-3 text-sm sm:text-base max-w-2xl mx-auto">Menyajikan informasi kegiatan, laporan keuangan, layanan zakat, dan layanan komunitas masjid.</p>
              <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ route('zakat.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg font-semibold">Hitung Zakat</a>
                <a href="{{ route('laporan.index') ?? '#' }}" class="inline-block bg-white text-gray-800 px-5 py-3 rounded-lg border">Lihat Laporan</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- WIDGETS: PRAYER TIMES + QUICK DONATE --}}
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Prayer times -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-lg mb-2">Waktu Sholat Hari Ini</h3>
      <div id="prayer-times" class="space-y-3 text-center">
        <!-- JS akan mengisi list ini -->
        <div class="p-3 border rounded">
          <div class="font-medium">Subuh</div>
          <div id="time-fajr" class="text-xl">--:--</div>
        </div>
        <div class="p-3 border rounded">
          <div class="font-medium">Terbit</div>
          <div id="time-sunrise" class="text-xl">--:--</div>
        </div>
        <div class="p-3 border rounded">
          <div class="font-medium">Dzuhur</div>
          <div id="time-dhuhr" class="text-xl">--:--</div>
        </div>
        <div class="p-3 border rounded">
          <div class="font-medium">Ashar</div>
          <div id="time-asr" class="text-xl">--:--</div>
        </div>
        <div class="p-3 border rounded">
          <div class="font-medium">Maghrib</div>
          <div id="time-maghrib" class="text-xl">--:--</div>
        </div>
        <div class="p-3 border rounded">
          <div class="font-medium">Isya</div>
          <div id="time-isha" class="text-xl">--:--</div>
        </div>
      </div>
      <p class="mt-3 text-xs text-gray-500">Sumber: Aladhan API (jika tersedia) — fallback statis bila gagal.</p>
    </div>

    <!-- Quick Donate + summary -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
      <div class="flex items-start justify-between">
        <div>
          <h3 class="font-semibold text-lg">Donasi Cepat</h3>
          <p class="text-sm text-gray-600">Dukung kegiatan masjid. Pilih nominal lalu lanjutkan ke proses pembayaran.</p>
        </div>
        <div class="text-right">
          <div class="text-xs text-gray-500">Terkumpul</div>
          <div class="text-2xl font-bold text-green-600">Rp {{ number_format($donasiSummary['total_terkumpul'] ?? 0, 0, ',', '.') }}</div>
          <div class="text-xs text-gray-500">{{ $donasiSummary['jumlah_transaksi'] ?? 0 }} transaksi</div>
        </div>
      </div>

      <form id="quick-donate-form" action="{{ route('donasi.store') ?? '#' }}" method="POST" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
        @csrf
        <input type="hidden" name="purpose" value="Donasi Cepat - Landing Page">
        <div>
          <label class="text-sm">Nama (opsional)</label>
          <input name="nama" class="w-full border rounded px-3 py-2" placeholder="Nama">
        </div>
        <div>
          <label class="text-sm">Nominal (Rp)</label>
          <select name="jumlah" class="w-full border rounded px-3 py-2">
            <option value="50000">Rp 50.000</option>
            <option value="100000">Rp 100.000</option>
            <option value="250000">Rp 250.000</option>
            <option value="500000">Rp 500.000</option>
            <option value="1000000">Rp 1.000.000</option>
            <option value="0">Nominal lain...</option>
          </select>
        </div>
        <div class="flex items-end">
          <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded px-4 py-2 font-semibold">Donasi Sekarang</button>
        </div>
      </form>

      <div class="mt-4 text-sm text-gray-500">
        <strong>Catatan:</strong> Donasi dapat dilakukan tanpa login. Pastikan email/nomor benar agar bukti dikirim.
      </div>
    </div>
  </section>

  {{-- SERVICES & BERITA --}}
  <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
      <h3 class="font-semibold text-lg mb-4">Layanan Kami</h3>
      <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <li class="p-4 border rounded">
          <strong>Zakat</strong>
          <p class="text-sm text-gray-600">Kalkulator & pembayaran zakat online.</p>
        </li>
        <li class="p-4 border rounded">
          <strong>Donasi</strong>
          <p class="text-sm text-gray-600">Donasi program, pembangunan, dan rutin.</p>
        </li>
        <li class="p-4 border rounded">
          <strong>Rukun Kematian</strong>
          <p class="text-sm text-gray-600">Pencatatan & iuran rukun kematian.</p>
        </li>
        <li class="p-4 border rounded">
          <strong>TPQ / TPA</strong>
          <p class="text-sm text-gray-600">Program taman pendidikan Al-Quran.</p>
        </li>
        <li class="p-4 border rounded">
          <strong>Ambulans</strong>
          <p class="text-sm text-gray-600">Layanan darurat terkoordinir.</p>
        </li>
        <li class="p-4 border rounded">
          <strong>Arisan Qurban</strong>
          <p class="text-sm text-gray-600">Program kolektif untuk qurban.</p>
        </li>
      </ul>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
      <h3 class="font-semibold text-lg mb-4">Berita Terbaru</h3>
      <div class="space-y-4">
        @forelse ($beritas as $b)
          <a href="{{ route('berita.publik.show', $b->slug) }}" class="block p-3 border rounded hover:shadow">
            <div class="font-semibold">{{ $b->judul }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $b->created_at->format('d F Y') }}</div>
          </a>
        @empty
          <p class="text-gray-500">Belum ada berita terbaru.</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- MAP + CONTACT --}}
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
      <h3 class="font-semibold text-lg mb-4">Lokasi Masjid</h3>
      <div class="w-full h-64 rounded overflow-hidden border">
        <!-- embed Google Maps via iframe. Replace src below with your iframe src if you have full embed link -->
        <iframe
          src="https://www.google.com/maps?q={{ urlencode($masjid['address']) }}&output=embed"
          class="w-full h-full" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>

    <aside class="bg-white rounded-lg shadow-sm p-6">
      <h3 class="font-semibold text-lg">Kontak & Media</h3>
      <p class="mt-2"><strong>Alamat</strong><br>{{ $masjid['address'] }}</p>
      <p class="mt-2"><strong>Telp/WA</strong><br>{{ $masjid['phone'] }}</p>
      <p class="mt-2"><strong>Email</strong><br>{{ $masjid['email'] }}</p>

      <div class="mt-4 space-x-2">
        <a href="{{ $masjid['instagram'] }}" target="_blank" class="inline-block text-sm px-3 py-1 border rounded">Instagram</a>
        <a href="{{ $masjid['facebook'] }}" target="_blank" class="inline-block text-sm px-3 py-1 border rounded">Facebook</a>
        <a href="{{ $masjid['youtube'] }}" target="_blank" class="inline-block text-sm px-3 py-1 border rounded">YouTube</a>
      </div>
    </aside>
  </section>

</div>

{{-- Footer --}}
<footer class="bg-gray-50 border-t mt-8">
  <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div>
        <h4 class="font-semibold">{{ $masjid['title'] }}</h4>
        <p class="text-sm text-gray-600 mt-2">{{ $masjid['address'] }}</p>
        <p class="text-sm text-gray-600 mt-1">Telp/WA: {{ $masjid['phone'] }}</p>
        <p class="text-sm text-gray-600 mt-1">Email: {{ $masjid['email'] }}</p>
      </div>
      <div>
        <h4 class="font-semibold">Layanan</h4>
        <ul class="mt-2 text-sm text-gray-600 space-y-1">
          <li><a href="{{ route('zakat.index') }}">Kalkulator Zakat</a></li>
          <li><a href="{{ route('donasi.create') }}">Donasi</a></li>
          <li><a href="#">Rukun Kematian</a></li>
          <li><a href="#">TPQ / TPA</a></li>
          <li><a href="#">Arisan Qurban</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold">Ikuti Kami</h4>
        <div class="mt-2 flex gap-2">
          <a href="{{ $masjid['instagram'] }}" target="_blank" class="text-sm px-3 py-1 rounded border">Instagram</a>
          <a href="{{ $masjid['facebook'] }}" target="_blank" class="text-sm px-3 py-1 rounded border">Facebook</a>
          <a href="{{ $masjid['youtube'] }}" target="_blank" class="text-sm px-3 py-1 rounded border">YouTube</a>
        </div>
      </div>
    </div>

    <div class="mt-6 text-center text-xs text-gray-500">
      © {{ date('Y') }} {{ $masjid['title'] }} — Semua hak dilindungi.
    </div>
  </div>
</footer>
@endsection

@section('scripts')
<script>
/*
  1) Slider: simple fade slider (vanilla JS)
*/
(function() {
  const slides = document.querySelectorAll('#hero-slider .slide');
  if (!slides.length) return;
  let idx = 0;
  setInterval(() => {
    slides[idx].classList.remove('opacity-100'); slides[idx].classList.add('opacity-0');
    idx = (idx + 1) % slides.length;
    slides[idx].classList.remove('opacity-0'); slides[idx].classList.add('opacity-100');
  }, 4500);
})();

/*
  2) Prayer times: try Aladhan API by city (Loa Janan, Indonesia) fallback static times
*/
(function(){
  const city = 'Loa Janan';
  const country = 'Indonesia';
  const method = 2; // Muslim World League or change as desired

  function fill(times) {
    document.getElementById('time-fajr').textContent = times.Fajr || '--:--';
    document.getElementById('time-sunrise').textContent = times.Sunrise || '--:--';
    document.getElementById('time-dhuhr').textContent = times.Dhuhr || '--:--';
    document.getElementById('time-asr').textContent = times.Asr || '--:--';
    document.getElementById('time-maghrib').textContent = times.Maghrib || '--:--';
    document.getElementById('time-isha').textContent = times.Isha || '--:--';
  }

  // fallback static schedule (local default) if API fails
  const fallback = {
    Fajr: '04:30', Sunrise: '06:00', Dhuhr: '12:00', Asr: '15:15', Maghrib: '18:00', Isha: '19:15'
  };

  fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=${method}`)
    .then(r => r.json())
    .then(data => {
      if (data && data.data && data.data.timings) {
        fill(data.data.timings);
      } else {
        fill(fallback);
      }
    })
    .catch(err => {
      console.warn('Aladhan API failed, using fallback times', err);
      fill(fallback);
    });
})();

</script>
@endsection
