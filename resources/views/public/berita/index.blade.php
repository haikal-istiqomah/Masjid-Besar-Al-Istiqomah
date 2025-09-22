<x-guest-layout>
    <div class="bg-gray-100 dark:bg-gray-900 pt-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Berita & Informasi Masjid</h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Ikuti kegiatan, pengumuman, dan artikel terbaru dari Masjid Al-Istiqomah.</p>
            </div>

            <!-- FORM FILTER DAN SORTING -->
            <div class="mb-8 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <form action="{{ route('berita.publik.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Kategori</label>
                        <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Kategori</option>
                            <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                            <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        </select>
                    </div>
                    <div>
                        <label for="urutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan</label>
                        <select name="urutan" id="urutan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="terbaru" {{ request('urutan', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('urutan') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Terapkan
                    </button>
                </form>
            </div>

            <!-- DAFTAR KARTU BERITA -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($semuaBerita as $berita)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                        <a href="{{ route('berita.publik.show', $berita) }}">
                            <img class="h-56 w-full object-cover" src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '[https://placehold.co/600x400/e2e8f0/e2e8f0](https://placehold.co/600x400/e2e8f0/e2e8f0)' }}" alt="{{ $berita->judul }}">
                        </a>
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex-grow">
                                <p class="text-sm text-blue-500 dark:text-blue-400 font-semibold">{{ ucfirst($berita->kategori) }}</p>
                                <a href="{{ route('berita.publik.show', $berita) }}" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 dark:text-white hover:text-blue-600">{{ $berita->judul }}</p>
                                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $berita->created_at->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada berita yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINASI -->
            <div class="mt-12">
                {{ $semuaBerita->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>

