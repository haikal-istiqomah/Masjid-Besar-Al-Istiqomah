<x-main-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div x-data="{ open: false }">
                        <div class="flex justify-between items-center border-b pb-4 mb-6">
                            <h1 class="text-3xl font-bold">Berita & Kegiatan Masjid</h1>
                            <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300">
                                <span x-text="open ? 'Sembunyikan Filter' : 'Tampilkan Filter'"></span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>

                        <div x-show="open" x-cloak class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg mb-8">
                            <form action="{{ route('berita.publik.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                                <div class="w-full md:w-1/3">
                                    <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                    <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Semua Kategori</option>
                                        <option value="Artikel" @selected(request('kategori') == 'Artikel')>Artikel</option>
                                        <option value="Kegiatan" @selected(request('kategori') == 'Kegiatan')>Kegiatan</option>
                                        <option value="Pengumuman" @selected(request('kategori') == 'Pengumuman')>Pengumuman</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-1/3">
                                    <label for="urutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan</label>
                                    <select name="urutan" id="urutan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="terbaru" @selected(request('urutan') == 'terbaru')>Terbaru</option>
                                        <option value="terlama" @selected(request('urutan') == 'terlama')>Terlama</option>
                                    </select>
                                </div>
                                <div class="mt-auto pt-5">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                        Terapkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($semuaBerita as $berita)
                            <div class="flex flex-col bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                                {{-- =============================================== --}}
                                {{-- == LINK #1 DIPERBAIKI DI SINI == --}}
                                {{-- =============================================== --}}
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
                                    <h2 class="text-xl font-bold mb-2 flex-grow">
                                        {{-- =============================================== --}}
                                        {{-- == LINK #2 DIPERBAIKI DI SINI == --}}
                                        {{-- =============================================== --}}
                                        <a href="{{ route('berita.publik.show', $berita->slug) }}" class="hover:text-blue-600">
                                            {{ $berita->judul }}
                                        </a>
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $berita->created_at->format('d F Y') }}
                                    </p>
                                    <div class="mt-4">
                                        <a href="{{ route('berita.publik.show', $berita->slug) }}" class="font-semibold text-blue-500 hover:text-blue-700">
                                            Baca Selengkapnya &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-1 lg:col-span-3 text-center py-12">
                                <p class="text-gray-500">Tidak ada berita yang cocok dengan filter yang dipilih.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $semuaBerita->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-main-layout>