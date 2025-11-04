@php $s = $result['transaction_status'] ?? 'unknown'; @endphp
<h1 class="text-2xl font-semibold mb-2">
  @if(in_array($s, ['settlement','capture'])) Alhamdulillah, pembayaran berhasil!
  @elseif($s === 'pending') Menunggu pembayaran
  @else Status transaksi: {{ strtoupper($s) }}
  @endif
</h1>
<p class="text-sm text-gray-600">Order ID: <strong>{{ $result['order_id'] ?? '-' }}</strong></p>
<p class="text-sm text-gray-600">Metode: <strong>{{ $result['payment_type'] ?? '-' }}</strong></p>
