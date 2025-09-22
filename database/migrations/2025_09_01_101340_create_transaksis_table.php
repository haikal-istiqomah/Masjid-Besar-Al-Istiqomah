<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->decimal('jumlah', 15, 2);
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']);
            // PASTIKAN BARIS INI SAMA PERSIS
            $table->enum('sumber', ['infaq', 'zakat maal', 'zakat fitrah', 'operasional', 'lainnya']);
            $table->string('metode_pembayaran')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};