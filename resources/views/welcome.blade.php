<x-main-layout>
    {{-- Bagian Hero/Selamat Datang --}}
    <div class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                Sistem Informasi Masjid Al-Istiqomah
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-300">
                Menyajikan informasi kegiatan, laporan keuangan, dan berita terkini seputar Masjid Al-Istiqomah.
            </p>
        </div>
    </div>

    {{-- Bagian Berita Terbaru --}}
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">Berita Terbaru</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($beritas as $berita)
                    <div class="flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                        <a href="{{ route('berita.publik.show', $berita->slug) }}">
                            @if ($berita->gambar)
                                <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar untuk {{ $berita->judul }}">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="mb-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $berita->kategori }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2 flex-grow">
                                <a href="{{ route('berita.publik.show', $berita->slug) }}" class="hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                                    {{ $berita->judul }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $berita->created_at->format('d F Y') }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('berita.publik.show', $berita->slug) }}" class="font-semibold text-blue-500 hover:text-blue-700 dark:text-blue-400">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('berita.publik.index') }}" class="inline-block bg-gray-800 text-white font-semibold px-6 py-3 rounded-lg hover:bg-gray-700">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </div>
</x-main-layout>