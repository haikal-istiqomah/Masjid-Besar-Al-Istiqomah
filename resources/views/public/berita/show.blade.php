<x-guest-layout>
    <div class="bg-white dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Tampilkan gambar berita, jika tidak ada, tampilkan placeholder --}}
                <img class="h-96 w-full object-cover" src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/1200x600/e2e8f0/e2e8f0?text=Gambar+Tidak+Tersedia' }}" alt="{{ $berita->judul }}">
                
                <div class="p-6 md:p-8">
                    {{-- Informasi Kategori dan Tanggal --}}
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold text-blue-500 dark:text-blue-400">{{ ucfirst($berita->kategori) }}</span>
                        <span class="mx-2">&bull;</span>
                        <span>Dipublikasikan pada {{ optional($berita->tanggal_publikasi)->format('d F Y') }}</span>
                    </div>
                    
                    {{-- Judul Berita --}}
                    <h1 class="mt-4 text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $berita->judul }}</h1>
                    
                    {{-- Konten/Isi Berita --}}
                    <div class="mt-8 prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {{-- Menggunakan nl2br untuk mengubah baris baru menjadi tag <br> agar format paragraf tetap rapi --}}
                        {!! nl2br(e($berita->isi)) !!}
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="mt-12">
                        <a href="{{ route('berita.publik.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            &larr; Kembali ke semua berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

