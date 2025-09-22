<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donasis', function (Blueprint $table) {
        $table->id();
        $table->string('order_id')->unique(); // ID unik untuk transaksi, penting untuk payment gateway
        $table->string('nama_donatur');
        $table->decimal('jumlah', 15, 2); // Angka besar untuk jumlah donasi
        $table->text('pesan')->nullable(); // Pesan atau doa dari donatur (opsional)
        $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Status pembayaran
        $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
