<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard & Ikhtisar Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Widget Utama (Statistik) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Zakat Terkumpul</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalZakat, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('admin.zakat.index') }}" class="text-xs text-green-600 hover:underline mt-2 block">Lihat Rincian &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Donasi Masuk</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('admin.donasi.laporan') }}" class="text-xs text-blue-600 hover:underline mt-2 block">Lihat Rincian &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Saldo Kas Operasional</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($saldoOps, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('admin.transaksi.index') }}" class="text-xs text-indigo-600 hover:underline mt-2 block">Kelola Kas &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                    <div class="text-gray-500 text-sm font-medium uppercase">Harga Emas (Per Gram)</div>
                    <div class="mt-2 text-2xl font-bold text-yellow-600">
                        Rp {{ number_format($hargaEmas, 0, ',', '.') }}
                    </div>
                    <div class="mt-2 text-xs text-gray-400 flex justify-between items-center">
                        <span>Live Update</span>
                        <form action="{{ route('admin.harga-emas.refresh') }}" method="POST">
                            @csrf
                            <button class="text-yellow-600 hover:text-yellow-800 font-semibold">🔄 Refresh</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Bagian Navigasi Cepat (Shortcut) --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.berita.create') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center gap-4 group">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                        📝
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">Tulis Berita Baru</div>
                        <div class="text-sm text-gray-500">Publikasikan kegiatan masjid</div>
                    </div>
                </a>

                <a href="{{ route('admin.transaksi.create') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center gap-4 group">
                    <div class="bg-green-100 p-3 rounded-full text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                        💰
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">Catat Transaksi</div>
                        <div class="text-sm text-gray-500">Input pemasukan/pengeluaran kas</div>
                    </div>
                </a>
                
                 <a href="{{ url('/') }}" target="_blank" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center gap-4 group">
                    <div class="bg-gray-100 p-3 rounded-full text-gray-600 group-hover:bg-gray-800 group-hover:text-white transition">
                        🌐
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">Lihat Website</div>
                        <div class="text-sm text-gray-500">Buka halaman depan publik</div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>