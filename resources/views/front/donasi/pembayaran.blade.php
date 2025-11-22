<x-guest-layout>
    {{--  Memuat library JavaScript Midtrans Snap dari CDN (lingkungan Sandbox) --}}
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 text-center">
                    
                    <h1 class="text-2xl font-bold mb-4">Menyiapkan Halaman Pembayaran...</h1>
                    <p class="mb-4">Pop-up pembayaran akan segera muncul.</p>
                    <p class="mb-6">Order ID Anda: <span class="font-mono bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">{{ $donasi->order_id }}</span></p>

                    {{-- Tombol ini sebagai cadangan jika pop-up tidak muncul otomatis --}}
                    <button id="pay-button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        Bayar Sekarang
                    </button>

                </div>
            </div>
        </div>
    </div>

    {{-- 2. Script untuk memanggil pop-up pembayaran Midtrans --}}
    <script type="text/javascript">
      // Ambil tombol pembayaran
      var payButton = document.getElementById('pay-button');
      
      // Fungsi untuk membuka pop-up pembayaran
      function openPaymentPopup() {
        // Gunakan snapToken yang dikirim dari controller
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* Pengguna akan diarahkan ke halaman utama setelah pembayaran sukses */
            console.log(result);
            window.location.href = "/donasi/sukses?order_id=" + result.order_id;
          },
          onPending: function(result){
            /* Pengguna akan diarahkan ke halaman utama selagi menunggu pembayaran (misal VA) */
            alert("Menunggu pembayaran. Silakan selesaikan transaksi Anda.");
          },
          onError: function(result){
            /* Jika terjadi error saat pembayaran */
            alert("Terjadi kesalahan saat memproses pembayaran.");
          },
          onClose: function(){
            /* Jika pengguna menutup pop-up tanpa menyelesaikan pembayaran */
             console.log("Popup Snap ditutup oleh pengguna tanpa menyelesaikan transaksi.");
            // mencegah redirect aneh dan cukup refresh form
            window.location.reload();
          }
        })
      }

      // Panggil fungsi pembayaran segera setelah halaman dimuat agar pop-up langsung muncul
      openPaymentPopup();

      // Tambahkan event listener ke tombol untuk antisipasi jika pop-up diblokir atau gagal muncul
      payButton.addEventListener('click', function () {
        openPaymentPopup();
      });
    </script>
</x-guest-layout>

