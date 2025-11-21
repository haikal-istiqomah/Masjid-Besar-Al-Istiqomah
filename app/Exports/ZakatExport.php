<?php

namespace App\Exports;

use App\Models\Zakat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class ZakatExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Zakat::query();

        // Filter status (ambil dari request URL)
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        // Filter jenis
        if ($this->request->filled('jenis')) {
            $query->where('jenis', $this->request->jenis);
        }
        
        return $query->latest(); 
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Tanggal Transaksi',
            'Nama Muzakki',
            'Email',
            'No. Telepon',
            'Jenis Zakat',
            'Nominal (Rp)',
            'Status Pembayaran',
            'Keterangan',
        ];
    }

    public function map($zakat): array
    {
        return [
            $zakat->order_id,
            $zakat->created_at->format('d-m-Y H:i'),
            $zakat->nama ?? 'Hamba Allah',
            $zakat->email ?? '-',
            $zakat->phone ?? '-',
            ucfirst($zakat->jenis),
            $zakat->jumlah,
            strtoupper($zakat->status),
            $zakat->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header Bold
        ];
    }
}