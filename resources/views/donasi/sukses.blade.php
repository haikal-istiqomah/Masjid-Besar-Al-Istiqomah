<div class="text-center py-10">
    <h1 class="text-2xl font-bold text-green-600">Terima Kasih, {{ $donasi->nama_donatur }}!</h1>
    <p>Donasi Anda sebesar <strong>Rp{{ number_format($donasi->jumlah) }}</strong> telah berhasil.</p>
    <p>Kode Transaksi: {{ $donasi->order_id }}</p>
    <a href="{{ route('donasi.index') }}" class="btn btn-primary mt-5">Kembali ke Halaman Donasi</a>
</div>
