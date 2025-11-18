<x-guest-layout>
    <div class="py-16">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-10 text-center">
                {{-- Pesan flash --}}
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 rounded-lg text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 rounded-lg text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Judul utama --}}
                <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">
                    Terima Kasih atas Donasi Anda 🙏
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Donasi Anda telah kami terima dan akan sangat membantu kegiatan Masjid Besar Al-Istiqomah.
                </p>

                {{-- Informasi transaksi --}}
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 mb-8">
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                        {{ $donasi->nama_donatur ?? 'Hamba Allah' }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 mb-1">
                        Jumlah Donasi:
                        <span class="font-bold text-green-600 dark:text-green-400">
                            Rp{{ number_format($donasi->jumlah, 0, ',', '.') }}
                        </span>
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 mb-1">
                        Kode Transaksi:
                        <span class="font-mono bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">
                            {{ $donasi->order_id }}
                        </span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                        Status Pembayaran: <span class="text-green-600 font-semibold">Berhasil</span>
                    </p>
                </div>

                {{-- Pesan doa --}}
                @if (!empty($donasi->pesan))
                    <div class="italic text-gray-700 dark:text-gray-300 mb-6">
                        “{{ $donasi->pesan }}”
                    </div>
                @endif

                {{-- Tombol navigasi --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-4">
                    <a href="{{ route('donasi.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                        Kembali ke Donasi
                    </a>
                    <a href="{{ url('/') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2.5 rounded-lg font-medium transition">
                        Ke Beranda
                    </a>
                    <a href="{{ route('donasi.cetak', $donasi->id) }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                        Cetak Bukti Donasi
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
