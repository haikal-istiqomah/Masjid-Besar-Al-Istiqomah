<?php

namespace App\Exports;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DonasiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Logika query ini SAMA PERSIS dengan di controller,
        // agar data yang diekspor sesuai dengan yang difilter.
        $query = Donasi::query();

        if ($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_akhir')) {
            $tanggalMulai = $this->request->tanggal_mulai;
            $tanggalAkhir = $this->request->tanggal_akhir;
            $query->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
        }

        return $query->latest()->get();
    }

    /**
     * Menentukan judul kolom (header) di file Excel.
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Nama Donatur',
            'Jumlah Donasi',
            'Status Pembayaran',
            'Pesan/Doa',
            'Tanggal Donasi',
        ];
    }

    /**
     * Memetakan data dari collection ke baris-baris Excel.
     */
    public function map($donasi): array
    {
        return [
            $donasi->order_id,
            $donasi->nama_donatur,
            $donasi->jumlah,
            ucfirst($donasi->status),
            $donasi->pesan,
            $donasi->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
