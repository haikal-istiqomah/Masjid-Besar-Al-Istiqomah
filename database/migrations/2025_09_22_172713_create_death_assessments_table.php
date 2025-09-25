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
        Schema::create('death_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('death_event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('unpaid'); // unpaid|paid
            $table->string('order_id')->nullable(); // jika bayar via Midtrans
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        
            $table->unique(['death_event_id','family_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death_assessments');
    }
};
