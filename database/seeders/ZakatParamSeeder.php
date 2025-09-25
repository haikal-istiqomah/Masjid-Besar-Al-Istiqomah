<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZakatParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ZakatParam::updateOrCreate(
            ['region' => 'Default', 'year' => now()->year],
            ['rice_price_per_kg' => 13500, 'fitrah_qty_kg' => 2.5, 'fidyah_qty_kg' => 0.675]
    );
    }
}
