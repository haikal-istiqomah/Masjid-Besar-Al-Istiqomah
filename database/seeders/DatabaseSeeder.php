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
        // 1. BUAT AKUN ADMIN (Penting agar tidak hilang saat reset)
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => '14alistiqomah@gmail.com',
            'role' => 'admin', // Pastikan role-nya admin
            'password' => bcrypt('adMlNn111'), // Password default
            'email_verified_at' => now(),
        ]);

        // 2. Buat user dummy (jamaah biasa)
        \App\Models\User::factory(10)->create();

        // 3. Panggil Seeder Lain
        $this->call([
            ZakatParamSeeder::class, 
        ]);
    }
}
