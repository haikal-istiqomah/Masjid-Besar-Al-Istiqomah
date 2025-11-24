<x-guest-layout>
  <div class="max-w-3xl mx-auto py-12 text-center">
    @if(request('transaction_status') === 'settlement' || request('transaction_status') === 'capture')
    @php 
        $zakat = \App\Models\Zakat::where('order_id', request('order_id'))->first();
    @endphp
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

    {{-- TAMBAHAN: Kotak Doa Hijau --}}
    @if($zakat && $zakat->status == 'paid')
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 mb-8 max-w-2xl mx-auto">
            <h3 class="text-emerald-800 font-bold mb-3 text-lg">Doa Penerima Zakat:</h3>
            <p class="text-2xl md:text-3xl font-serif text-emerald-900 mb-4 leading-relaxed" dir="rtl">
                آجَرَكَ اللَّهُ فِيْمَا اَعْطَيْتَ، وَبَارَكَ فِيْمَا اَبْقَيْتَ وَجَعَلَهُ لَكَ طَهُوْرًا
            </p>
            <p class="text-sm text-emerald-700 italic">
                "Semoga Allah memberikan pahala kepadamu pada harta yang engkau zakatkan, 
                dan semoga Allah memberkahi harta yang masih engkau sisakan."
            </p>
        </div>
    @endif

    <div class="border rounded p-6 bg-white shadow-md text-left">
      <h3 class="text-lg font-semibold mb-4">Detail Transaksi</h3>
      <p><strong>Order ID:</strong> {{ request('order_id') }}</p>
      <p><strong>Status:</strong> {{ request('transaction_status') }}</p>
      <p><strong>Jenis Pembayaran:</strong> {{ request('payment_type') }}</p>
      <p><strong>Nominal:</strong> Rp {{ number_format(request('gross_amount', 0), 0, ',', '.') }}</p>
    </div>
    
    
    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
      <a href="{{ route('zakat.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Kalkulator</a>
      
      @if($zakat && $zakat->status == 'paid')
      <a href="{{ route('zakat.cetak', $zakat->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
          Cetak Bukti
      </a>
      @endif
      
      <a href="{{ route('front.landing') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Beranda</a>
    </div>
  </div>
</x-guest-layout>
