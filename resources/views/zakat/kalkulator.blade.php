<x-guest-layout>
  <h1 class="text-2xl font-semibold mb-4">Kalkulator Zakat</h1>

  <form action="{{ route('zakat.hitung') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Wilayah/Region</label>
      <input name="region" class="border rounded p-2 w-full" placeholder="Mis. Bandar Lampung" required>
    </div>
    <div>
      <label class="block mb-1">Jumlah Hari Fidyah (opsional)</label>
      <input type="number" name="jumlah_hari" min="1" class="border rounded p-2 w-full" placeholder="Mis. 3">
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Hitung</button>
  </form>

  @if (session()->has('fitrah_uang'))
    <div class="mt-6 p-4 border rounded">
      <p><strong>Region:</strong> {{ session('region') }}</p>
      <p><strong>Zakat Fitrah (uang):</strong> Rp {{ number_format(session('fitrah_uang'),0,',','.') }}</p>
      @if (session('fidyah_uang'))
        <p><strong>Fidyah (uang):</strong> Rp {{ number_format(session('fidyah_uang'),0,',','.') }}</p>
      @endif
    </div>
  @endif
</x-guest-layout>
