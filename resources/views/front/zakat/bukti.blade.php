<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Zakat - {{ $zakat->order_id }}</title>
    <style>
        /* Ganti font-family utama menjadi DejaVu Sans agar support Arab & Rupiah */
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; margin: 0; padding: 20px; }
        
        .kop-surat { width: 100%; border-bottom: 3px double #166534; padding-bottom: 10px; margin-bottom: 30px; }
        .kop-surat td { vertical-align: middle; }
        .logo { width: 90px; height: auto; }
        
        /* Institusi tetap pakai sans-serif biasa biar rapi, atau ikut DejaVu juga boleh */
        .institusi { text-align: center; font-family: sans-serif; }
        .nama-masjid { font-size: 24px; font-weight: bold; color: #166534; text-transform: uppercase; margin-bottom: 5px; }
        .alamat { font-size: 13px; color: #555; line-height: 1.4; }
        
        .judul-bukti { text-align: center; margin-bottom: 30px; font-size: 18px; font-weight: bold; text-decoration: underline; letter-spacing: 1px; }
        .tabel-data { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .tabel-data td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .label { width: 180px; font-weight: bold; color: #444; }
        
        .total-row { background-color: #f0fdf4; font-weight: bold; font-size: 14px; }
        
        /* Doa perlu font khusus dan arah teks kanan-ke-kiri */
        .doa-box { border: 1px dashed #166534; padding: 20px; text-align: center; margin-top: 20px; background-color: #f0fdf4; border-radius: 10px; }
        .arabic { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 20px; 
            margin-bottom: 10px; 
            display: block; 
            color: #166534; 
            direction: rtl; /* Arah teks Arab */
        }
        .arti { font-size: 12px; font-style: italic; color: #666; font-family: sans-serif; }
        
        .ttd { float: right; width: 220px; text-align: center; margin-top: 40px; font-size: 13px; }
    </style>
</head>
<body>

    {{-- 1. KOP SURAT RESMI (Penting untuk kesan formal) --}}
    <table class="kop-surat">
        <tr>
            <td width="15%" align="center">
                {{-- Pastikan logo ada di public/images/logo-masjid.jpg --}}
                <img src="{{ public_path('images/logo-masjid.jpg') }}" class="logo" alt="Logo">
            </td>
            <td width="85%" class="institusi">
                <div class="nama-masjid">Yayasan Masjid Besar Al-Istiqomah</div>
                <div class="alamat">
                    Jl. Gerbang Dayaku RT.06, Desa Loa Duri Ilir, Kec. Loa Janan <br>
                    Kabupaten Kutai Kartanegara, Kalimantan Timur 75391 <br>
                    Email: alistiqomah14@gmail.com | WA: 0822-5458-9345
                </div>
            </td>
        </tr>
    </table>

    <div class="judul-bukti">TANDA TERIMA ZAKAT</div>

    <table class="tabel-data">
        <tr>
            <td class="label">Kode Transaksi</td>
            <td>: <strong>{{ $zakat->order_id }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal & Jam</td>
            <td>: {{ $zakat->created_at->translatedFormat('l, d F Y H:i') }} WITA</td>
        </tr>
        <tr>
            <td class="label">Nama Muzakki</td>
            <td>: {{ $zakat->nama }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Zakat</td>
            <td>: {{ ucfirst($zakat->jenis) }}</td>
        </tr>
        <tr>
            <td class="label">Nominal</td>
            <td>: <strong>Rp {{ number_format($zakat->jumlah, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>: <span style="color: green; font-weight: bold;">LUNAS (PAID)</span></td>
        </tr>
    </table>

    {{-- 2. DOA (Sunnah Nabi saat menerima zakat) --}}
    <div class="doa-box">
        <img src="{{ public_path('images/doa_zakat.png') }}" 
            style="width: 90%; max-width: 600px; height: auto; display: block; margin: 0 auto 15px auto;" 
            alt="Doa Zakat">

        <div class="arti">
            "Semoga Allah memberikan pahala kepadamu pada barang yang engkau berikan (zakatkan), 
            dan semoga Allah memberkahi dalam harta-harta yang masih engkau sisakan, 
            dan semoga pula menjadikannya sebagai pembersih (dosa) bagimu."
        </div>
    </div>

    <div class="ttd">
        Kutai Kartanegara, {{ now()->translatedFormat('d F Y') }}<br>
        Panitia Amil Zakat,<br>
        <br><br><br><br>
        <strong>( _______________________ )</strong>
    </div>

</body>
</html>