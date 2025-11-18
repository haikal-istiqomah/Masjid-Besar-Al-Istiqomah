<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Donasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 30px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { color: #2E7D32; }
        .detail { margin-bottom: 20px; }
        .detail p { margin: 6px 0; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bukti Donasi Masjid Besar Al-Istiqomah</h2>
        <p>Terima kasih atas kebaikan Anda 🙏</p>
    </div>

    <div class="detail">
        <p><strong>Nama Donatur:</strong> {{ $donasi->nama_donatur ?? 'Hamba Allah' }}</p>
        <p><strong>Jumlah Donasi:</strong> Rp{{ number_format($donasi->jumlah, 0, ',', '.') }}</p>
        <p><strong>Kode Transaksi:</strong> {{ $donasi->order_id }}</p>
        <p><strong>Tanggal:</strong> {{ $donasi->created_at->format('d F Y, H:i') }}</p>
        @if($donasi->pesan)
        <p><strong>Pesan/Doa:</strong> "{{ $donasi->pesan }}"</p>
        @endif
    </div>

    <div class="footer">
        <p>Masjid Besar Al-Istiqomah - Desa Loa Duri Ilir, Kec. Loa Janan, Kutai Kartanegara</p>
        <p>Website resmi: {{ url('/') }}</p>
    </div>
</body>
</html>
