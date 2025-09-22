<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 10 user contoh
    \App\Models\User::factory(10)->create();
    
    // Memanggil PostSeeder untuk membuat 15 postingan
    $this->call([
        PostSeeder::class,
    ]);
    }
}
