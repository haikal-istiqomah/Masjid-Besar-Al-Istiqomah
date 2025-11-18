<x-app-layout>
  <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📊 Harga Emas Terkini</h2>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <p class="text-gray-700 text-lg mb-2">Harga per gram saat ini:</p>
    <p class="text-3xl font-bold text-yellow-600 mb-4">Rp {{ number_format($harga, 0, ',', '.') }}</p>

    <p class="text-sm text-gray-500 mb-6">Terakhir diperbarui (cache 1 jam): {{ $lastUpdated }}</p>

    <form action="{{ route('admin.harga-emas.refresh') }}" method="POST">
      @csrf
      <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
        🔄 Perbarui Harga Sekarang
      </button>
    </form>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const badge = document.querySelector('.bg-yellow-50');
      if (badge) {
        badge.classList.add('ring-2', 'ring-green-400');
        setTimeout(() => badge.classList.remove('ring-2', 'ring-green-400'), 2000);
      }
    });
  </script>
</x-app-layout>
