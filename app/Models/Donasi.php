<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'nama_donatur',
        'email',
        'jumlah',
        'pesan',
        'status', // Meskipun status diatur otomatis, kita izinkan untuk update nanti
        'payment_type',
    ];

    // ... kode yang sudah ada ...

    // Accessor untuk Label Metode Pembayaran yang rapi
    public function getMetodePembayaranLabelAttribute()
    {
        return match($this->payment_type) {
            'echannel'      => 'Mandiri Bill',
            'bank_transfer' => 'Transfer Bank',
            'credit_card'   => 'Kartu Kredit',
            'qris'          => 'QRIS',
            'gopay'         => 'GoPay',
            'shopeepay'     => 'ShopeePay',
            default         => ucwords(str_replace('_', ' ', $this->payment_type ?? '-')),
        };
    }

    // Accessor untuk Warna Badge Status
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'success', 'paid', 'settlement', 'capture' => 'bg-green-100 text-green-800 border-green-200',
            'pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'failed', 'deny', 'cancel' => 'bg-red-100 text-red-800 border-red-200',
            'expired'  => 'bg-gray-200 text-gray-800 border-gray-300',
            default    => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}