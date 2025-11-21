<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Db :: table jauh lebih cepat dibanding Eloquent untuk seeding sederhana

class ZakatParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // User dummy
        DB::table('zakat_params')->updateOrInsert(
            ['region' => 'Default', 'year' => 2025], // Kunci pencarian
            [
                'rice_price_per_kg' => 13500,
                'fitrah_qty_kg' => 2.5,
                'fidyah_qty_kg' => 0.675,
                'created_at' => now(),
                'updated_at' => now(),
            
        ]);
    }
}
