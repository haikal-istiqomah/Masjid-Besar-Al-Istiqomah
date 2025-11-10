@extends('layouts.app')

@section('content')
<div class="text-center p-10">
  <h2 class="text-2xl font-bold text-green-600">Terima Kasih, {{ $donasi->nama_donatur ?? 'Donatur' }}!</h2>
  <p class="mt-2">Donasi Anda sebesar <strong>Rp{{ number_format($donasi->jumlah, 0, ',', '.') }}</strong> telah berhasil.</p>
  <p>Kode Transaksi: {{ $donasi->order_id }}</p>
  <div class="mt-6">
    <a href="{{ route('donasi.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Kembali ke Donasi</a>
    <a href="{{ url('/') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Ke Beranda</a>
  </div>
</div>
@endsection
