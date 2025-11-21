<x-guest-layout>
  <div class="max-w-3xl mx-auto py-12 text-center">
    @if(request('transaction_status') === 'settlement' || request('transaction_status') === 'capture')
      <div class="p-4 mb-6 bg-green-100 text-green-800 rounded-lg">
        <h2 class="text-5xl font-semibold mb-2">Alhamdulillah </h2>
        <p>Zakat Anda telah berhasil diterima</p>
        <p>Terima kasih telah menunaikan kebaikan dan semoga barokah.</p>
    </div>
    @elseif(request('transaction_status') === 'pending')
      <div class="p-4 mb-6 bg-yellow-100 text-yellow-800 rounded-lg">
        <h2 class="text-2xl font-semibold mb-2">Menunggu Pembayaran</h2>
        <p>Silakan selesaikan transaksi Anda sesuai metode pembayaran yang dipilih.</p>
      </div>
    @else
      <div class="p-4 mb-6 bg-red-100 text-red-800 rounded-lg">
        <h2 class="text-2xl font-semibold mb-2">Transaksi Gagal</h2>
        <p>Terjadi kesalahan atau transaksi Anda dibatalkan.</p>
      </div>
    @endif

    <div class="border rounded p-6 bg-white shadow-md text-left">
      <h3 class="text-lg font-semibold mb-4">Detail Transaksi</h3>
      <p><strong>Order ID:</strong> {{ request('order_id') }}</p>
      <p><strong>Status:</strong> {{ request('transaction_status') }}</p>
      <p><strong>Jenis Pembayaran:</strong> {{ request('payment_type') }}</p>
      <p><strong>Nominal:</strong> Rp {{ number_format(request('gross_amount', 0), 0, ',', '.') }}</p>
    </div>

    <div class="mt-8 flex justify-center gap-3">
      <a href="{{ route('zakat.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Kembali ke Kalkulator</a>
      <a href="{{ route('front.landing') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Beranda</a>
    </div>
  </div>
</x-guest-layout>
