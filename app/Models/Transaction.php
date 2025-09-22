<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'description',
        'type',
        'category',
        'payment_method',
        'status',
    ];

    /**
 * Get the user that owns the transaction.
 */
public function user()
{
    return $this->belongsTo(User::class);
}
}