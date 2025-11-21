<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    protected $fillable = [
        'order_id',
        'nama',
        'email',
        'phone',
        'jenis',
        'jumlah',
        'nominal_perhitungan',
        'keterangan',
        'region',
        'status',
        'midtrans_response'
    ];

    protected $casts = [
        'midtrans_response' => 'array',
    ];
}
