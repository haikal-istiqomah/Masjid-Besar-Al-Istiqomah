<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Buka file di: database/migrations/xxxx_xx_xx_xxxxxx_create_beritas_table.php

public function up(): void
{
    Schema::create('beritas', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('slug')->unique(); // Untuk URL yang cantik, cth: /berita/ini-judul-berita
        $table->string('kategori');
        $table->text('konten');
        $table->string('gambar')->nullable(); // Nama file gambar, boleh kosong
        // $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
        $table->timestamps(); // Otomatis membuat kolom created_at dan updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
