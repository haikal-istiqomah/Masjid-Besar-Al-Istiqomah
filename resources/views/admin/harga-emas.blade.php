<x-app-layout>
  <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📊 Kelola Harga Emas</h2>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mb-6 text-center">
        <p class="text-gray-700 text-lg">Harga Acuan Saat Ini</p>
        <p class="text-4xl font-bold text-yellow-600 mt-2">Rp {{ number_format($harga, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 mt-2">Per gram</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- CARD 1: UPDATE MANUAL (UTAMA) --}}
        <div class="border p-4 rounded">
            <h3 class="font-bold text-gray-700 mb-2">✏️ Update Manual</h3>
            <p class="text-xs text-gray-500 mb-4">Gunakan harga resmi Antam/Pasar hari ini.</p>
            
            <form action="{{ route('admin.harga-emas.update') }}" method="POST" id="manualGoldForm">
                @csrf
                <div class="mb-3">
                    {{-- Input Tampilan (Format Rupiah) --}}
                    <input type="text" id="display_price" class="w-full border-gray-300 rounded-md font-mono text-lg" placeholder="Contoh: 1.350.000" required>
                    
                    {{-- Input Asli (Hidden, Polos) --}}
                    <input type="hidden" name="price" id="real_price">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    Simpan Harga Manual
                </button>
            </form>

            <script>
                const displayInput = document.getElementById('display_price');
                const realInput = document.getElementById('real_price');

                displayInput.addEventListener('input', function(e) {
                    // Hapus karakter non-angka
                    let val = this.value.replace(/[^0-9]/g, '');
                    // Simpan nilai asli ke input hidden
                    realInput.value = val;
                    // Format tampilan dengan titik
                    if(val) {
                        this.value = new Intl.NumberFormat('id-ID').format(val);
                    } else {
                        this.value = '';
                    }
                });
            </script>
        </div>

        {{-- CARD 2: UPDATE API (OPSIONAL) --}}
        <div class="border p-4 rounded bg-gray-50">
            <h3 class="font-bold text-gray-700 mb-2">🔄 Sync API Otomatis</h3>
            <p class="text-xs text-gray-500 mb-4">Ambil dari server Metals-Live (Sering tidak stabil).</p>
            
            <form action="{{ route('admin.harga-emas.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">
                    Coba Tarik Data API
                </button>
            </form>
        </div>
    </div>


  </div>
</x-app-layout>