<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatParam extends Model
{
    // Menentukan nama tabel secara eksplisit (opsional, tapi aman)
    protected $table = 'zakat_params';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'region', 
        'year', 
        'rice_price_per_kg', 
        'fitrah_qty_kg', 
        'fidyah_qty_kg', 
        'effective_at', 
        'notes'
    ];

    // Casting tipe data agar otomatis dikonversi
    protected $casts = [
        'rice_price_per_kg' => 'decimal:2',
        'fitrah_qty_kg' => 'decimal:2',
        'fidyah_qty_kg' => 'decimal:3',
        'effective_at' => 'date',
    ];
}