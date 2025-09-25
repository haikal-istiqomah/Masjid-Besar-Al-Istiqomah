<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','user_id','amount','currency','product_type',
        'payable_type','payable_id','status','channel','snap_token','paid_at','raw_notification'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'raw_notification' => 'array',
    ];

    public function payable() { return $this->morphTo(); }
    public function user() { return $this->belongsTo(User::class); }
}
