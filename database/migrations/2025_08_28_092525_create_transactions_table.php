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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->string('invoice_id')->unique();
        $table->bigInteger('amount');
        $table->text('description');
        $table->enum('type', ['pemasukan', 'pengeluaran']);
        $table->string('category');
        $table->enum('payment_method', ['cash', 'midtrans'])->default('cash');
        $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
