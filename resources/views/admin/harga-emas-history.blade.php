<x-app-layout>
  <div class="max-w-5xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📈 Riwayat Harga Emas</h2>

    @if (session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border border-gray-300 text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-3 py-2 text-left">Tanggal</th>
          <th class="border px-3 py-2 text-left">Harga per Gram</th>
          <th class="border px-3 py-2 text-left">Sumber</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($histories as $item)
          <tr>
            <td class="border px-3 py-2">{{ $item->created_at->format('d M Y, H:i') }}</td>
            <td class="border px-3 py-2">Rp {{ number_format($item->price_per_gram, 0, ',', '.') }}</td>
            <td class="border px-3 py-2">{{ $item->source }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-8">
      <canvas id="goldChart" height="100"></canvas>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('goldChart');
    const data = {
      labels: @json($histories->pluck('created_at')->map(fn($d) => $d->format('d M'))),
      datasets: [{
        label: 'Harga Emas (Rp)',
        data: @json($histories->pluck('price_per_gram')),
        borderColor: '#fbbf24',
        backgroundColor: 'rgba(251,191,36,0.2)',
        borderWidth: 2,
        fill: true,
        tension: 0.3
      }]
    };
    new Chart(ctx, { type: 'line', data });
  </script>
</x-app-layout>
