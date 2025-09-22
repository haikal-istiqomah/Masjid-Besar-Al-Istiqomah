<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Blok untuk menampilkan SEMUA error validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium">Judul Berita</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="kategori" class="block text-sm font-medium">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="artikel" {{ old('kategori', $berita->kategori) == 'artikel' ? 'selected' : '' }}>Artikel</option>
                                <option value="pengumuman" {{ old('kategori', $berita->kategori) == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="kegiatan" {{ old('kategori', $berita->kategori) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="isi" class="block text-sm font-medium">Isi Berita</label>
                            <textarea name="isi" id="isi" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600" required>{{ old('isi', $berita->isi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="block text-sm font-medium">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" id="gambar" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" onchange="previewImage(event)">
                        </div>
                        
                        <div class="mb-4">
                             <label class="block text-sm font-medium">Gambar Saat Ini</label>
                            {{-- Tampilkan gambar yang sudah ada atau placeholder --}}
                            <img id="image-preview" src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '#' }}" alt="Pratinjau Gambar" class="{{ $berita->gambar ? '' : 'hidden' }} h-48 w-auto rounded-md mt-2"/>
                            @if ($berita->gambar)
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk mempertahankan gambar saat ini.</p>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="tanggal_publikasi" class="block text-sm font-medium">Tanggal Publikasi</label>
                            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" value="{{ old('tanggal_publikasi', optional($berita->tanggal_publikasi)->format('Y-m-d')) }}" class="mt-1 rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600" required>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            var imageField = document.getElementById("image-preview");
            
            reader.onload = function() {
                if (reader.readyState == 2) {
                    imageField.classList.remove('hidden');
                    imageField.src = reader.result;
                }
            }
            
            if (event.target.files && event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                imageField.classList.add('hidden');
                imageField.src = '#'; // Hapus gambar pratinjau jika file dihapus
            }
        }
    </script>
</x-app-layout>