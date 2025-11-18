<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Selamat Datang, {{ Auth::user()->name }}</h2>

    {{-- Widget Harga Emas --}}
    <div class="bg-white shadow-sm border border-gray-100 rounded-lg p-5 mb-8 flex flex-col md:flex-row justify-between items-center">
      <div>
        <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
          💰 Harga Emas Saat Ini
        </h3>
        <p class="text-3xl font-bold text-yellow-600 mt-2 transition-all duration-300 hover:scale-[1.02]">
          Rp {{ number_format(app(\App\Services\GoldPriceService::class)->getGoldPrice(), 0, ',', '.') }}
        </p>
        <p class="text-sm text-gray-500 mt-1">(cache otomatis 1 jam)</p>
      </div>

      <form action="{{ route('admin.harga-emas.refresh') }}" method="POST" class="mt-4 md:mt-0">
        @csrf
        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded shadow transition transition-all duration-300 hover:scale-[1.02]">
          🔄 Perbarui
        </button>
      </form>
    </div>

    {{-- Konten dashboard lain --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      {{--Laporan Keuangan  --}}
      <div class="bg-white rounded-lg shadow p-6 transition-all duration-300 hover:scale-[1.02]">
        <h4 class="text-lg font-semibold mb-2">📈 Laporan Keuangan</h4>
        <p class="text-gray-600 text-sm">Kelola dan pantau arus kas Masjid.</p>
        <a href="{{ route('admin.transaksi.index') }}" class="text-blue-600 hover:underline mt-3 inline-block text-sm transition-all duration-300 hover:scale-[1.02]">Lihat Detail →</a>
      </div>

      {{--Manajemen Berita--}}
      <div class="bg-white rounded-lg shadow p-6 transition-all duration-300 hover:scale-[1.02]">
        <h4 class="text-lg font-semibold mb-2">📰 Manajemen Berita</h4>
        <p class="text-gray-600 text-sm">Publikasikan berita kegiatan dan pengumuman.</p>
        <a href="{{ route('admin.berita.index') }}" class="text-blue-600 hover:underline mt-3 inline-block text-sm transition-all duration-300 hover:scale-[1.02]">Kelola Berita →</a>
      </div>

        {{--Laporan Donasi--}} 
      <div class="bg-white rounded-lg shadow p-6 transition-all duration-300 hover:scale-[1.02]">
        <h4 class="text-lg font-semibold mb-2">💝 Laporan Donasi</h4>
        <p class="text-gray-600 text-sm">Pantau donasi jamaah dan sumber dana.</p>
        <a href="{{ route('admin.donasi.laporan') }}" class="text-blue-600 hover:underline mt-3 inline-block text-smtransition-all duration-300 hover:scale-[1.02]">Lihat Donasi →</a>
      </div>
    </div>
  </div>
</x-app-layout>
