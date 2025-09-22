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
    ];
}