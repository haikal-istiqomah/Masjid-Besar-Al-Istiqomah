<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatParam extends Model
{
    public function scopeRegionYear($q, $region, $year) {
        return $q->whereRaw('LOWER(region) = ?', [strtolower($region)])->where('year', $year);
    }
}
