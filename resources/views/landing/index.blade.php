<x-main-layout>
  {{-- Hero / Slider --}}
  <section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
        <div>
          <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Selamat Datang di Masjid Besar Al-Istiqomah</h1>
          <p class="mt-4 text-lg text-gray-600">Menyajikan informasi kegiatan, laporan keuangan, berita, layanan zakat dan donasi.</p>
          <div class="mt-6 flex gap-3">
            <a href="{{ route('zakat.index') }}" class="bg-green-600 text-white px-5 py-3 rounded-md font-semibold shadow">Hitung Zakat</a>
            <a href="{{ route('laporan.index') }}" class="bg-white border px-5 py-3 rounded-md font-semibold">Lihat Laporan</a>
          </div>
        </div>

        <div class="rounded-lg overflow-hidden shadow">
          {{-- Simple slider (js minimal) --}}
          <div id="landing-slider" class="relative">
            @foreach($slider as $i => $img)
              <img
                src="{{ $img }}"
                class="w-full h-56 md:h-64 object-cover transition-opacity duration-500 {{ $i !== 0 ? 'hidden' : '' }}"
                data-slide-index="{{ $i }}">
            @endforeach
            <div class="absolute left-2 top-2 bg-white/60 px-3 py-1 rounded text-sm">Foto Kegiatan</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Waktu Sholat --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
      <h2 class="text-xl font-semibold mb-4">Waktu Sholat Hari Ini</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach(['Fajr'=>'Subuh','Sunrise'=>'Terbit','Dhuhr'=>'Dzuhur','Asr'=>'Ashar','Maghrib'=>'Maghrib','Isha'=>'Isya'] as $key => $label)
          <div class="bg-white p-4 rounded shadow text-center">
            <div class="text-sm text-gray-500">{{ $label }}</div>
            <div class="mt-2 text-xl font-medium text-gray-700">{{ $prayerTimes[$key] ?? '--:--' }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Donasi ringkas & layanan --}}
  <section class="py-8">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold">Tombol Donasi Cepat</h3>
          <p class="text-sm text-gray-500 mt-2">Donasi untuk program: <strong>{{ $donationSummary['program'] }}</strong></p>

          <div class="mt-4 flex items-center gap-4">
            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($donationSummary['month_total'],0,',','.') }}</div>
            <a href="{{ route('donasi.create') }}" class="ml-auto bg-yellow-500 text-white px-4 py-2 rounded-md font-semibold">Donasi Sekarang</a>
          </div>

          <div class="mt-6">
            <h4 class="font-medium text-sm text-gray-700 mb-2">Donatur Terbaru</h4>
            <ul class="text-sm text-gray-600 space-y-1">
              @foreach($donationSummary['recent'] as $r)
                <li>{{ $r['name'] }} — Rp {{ number_format($r['amount'],0,',','.') }}</li>
              @endforeach
            </ul>
          </div>
        </div>

        <div class="mt-6 bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-4">Layanan</h3>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($services as $s)
              <a href="{{ $s['link'] }}" class="block p-3 border rounded hover:bg-gray-50 text-center">
                {{ $s['title'] }}
              </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Maps --}}
      <div>
        <div class="bg-white p-4 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-3">Lokasi Masjid</h3>
          <div class="w-full h-48 rounded overflow-hidden">
            <iframe
              src="https://www.google.com/maps?q={{ $mapsQuery }}&output=embed"
              class="w-full h-full border-0"
              allowfullscreen=""
              loading="lazy"></iframe>
          </div>
          <div class="mt-3 text-sm">
            <a href="https://maps.app.goo.gl/7rbuW8pTqgfT12Ty8" target="_blank" class="text-blue-600">Lihat di Google Maps</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Footer (simple include) --}}
  <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between">
      <div>
        <h4 class="text-lg font-bold">Masjid Besar Al-Istiqomah</h4>
        <p class="text-sm mt-2">Loa Duri Ilir, Kutai Kartanegara — Kalimantan Timur</p>
        <p class="text-sm mt-1">Email: info@masjid.example • Telp: 08xx-xxxx</p>
      </div>
      <div class="mt-4 md:mt-0">
        <h5 class="font-semibold">Ikuti Kami</h5>
        <div class="flex gap-3 mt-2">
          <a href="#" class="text-sm">Facebook</a>
          <a href="#" class="text-sm">Instagram</a>
          <a href="#" class="text-sm">YouTube</a>
        </div>
      </div>
    </div>
  </footer>

  {{-- Minimal JS: slider --}}
  <script>
    (function(){
      const slides = Array.from(document.querySelectorAll('#landing-slider img'));
      let idx = 0;
      setInterval(()=> {
        slides[idx].classList.add('hidden');
        idx = (idx + 1) % slides.length;
        slides[idx].classList.remove('hidden');
      }, 4000);
    })();
  </script>

</x-main-layout>
