<x-guest-layout>
  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
        <h2 class="text-2xl font-semibold mb-4">Pembayaran Zakat</h2>
        <p class="mb-4">Order ID: <span class="font-mono">{{ $zakat->order_sid }}</span></p>
        <p class="mb-6">Jumlah yang harus dibayar: <strong>Rp {{ number_format($zakat->jumlah, 0, ',', '.') }}</strong></p>
        <button id="pay-button" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
          Bayar Sekarang
        </button>
      </div>
    </div>
  </div>

  {{-- Script Midtrans --}}
  <script type="text/javascript"
          src="https://app.sandbox.midtrans.com/snap/snap.js"
          data-client-key="{{ config('midtrans.client_key') }}"></script>
  <script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
          console.log('Pembayaran sukses:', result);
          //  redirect ke halaman sukses zakat
          window.location.href = "/zakat/finish?" + new URLSearchParams(result).toString();
        },
        onPending: function(result){
          alert("Menunggu pembayaran. Silakan selesaikan transaksi Anda.");
        },
        onError: function(result){
          alert("Terjadi kesalahan saat memproses pembayaran.");
          console.error(result);
        },
        onClose: function(){
          alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
        }
      });
    });
  </script>
</x-guest-layout>
