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
        Schema::create('zakat_params', function (Blueprint $table) {
    $table->id();
    $table->string('region')->default('Default'); // bisa: Kota/Kecamatan
    $table->year('year');
    $table->decimal('rice_price_per_kg', 12, 2); // harga beras
    $table->decimal('fitrah_qty_kg', 5, 2)->default(2.5);
    $table->decimal('fidyah_qty_kg', 5, 3)->default(0.675);
    $table->date('effective_at')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->unique(['region','year']);
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zakat_params');
    }
};
