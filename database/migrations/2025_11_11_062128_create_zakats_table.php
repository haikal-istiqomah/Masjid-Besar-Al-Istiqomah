<?php

// database/migrations/2025_xx_xx_create_zakats_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZakatsTable extends Migration
{
    public function up()
    {
        Schema::create('zakats', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // mis. ZAKAT-PROFESI-20251111-XXXX
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('jenis', ['profesi','maal','perniagaan']); // jenis zakat
            $table->decimal('jumlah', 15, 2); // nominal final dibayarkan
            $table->decimal('nominal_perhitungan', 15, 2)->nullable(); // hasil kalkulasi (bila dihitung otomatis)
            $table->text('keterangan')->nullable(); // input tambahan
            $table->string('region')->nullable(); // utk fitrah/fidyah jika diperlukan
            $table->enum('status', ['pending','paid','expired','cancelled','failed'])->default('pending');
            $table->json('midtrans_response')->nullable(); // simpan response snap/finish (opsional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zakats');
    }
}
