<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('IDR');
            $table->string('product_type'); // donation|zakat|spp|iuran
            $table->nullableMorphs('payable'); // payable_type, payable_id
            $table->string('status')->default('pending'); // pending|paid|failed|expired|canceled|refunded|partially_refunded|chargeback
            $table->string('channel')->nullable(); // qris|va|gopay|shopeepay|dll
            $table->string('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->jsonb('raw_notification')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
