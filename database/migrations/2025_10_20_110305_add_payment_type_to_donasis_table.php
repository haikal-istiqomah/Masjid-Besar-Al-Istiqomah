<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donasis', function (Blueprint $table) {
            // panjang 50 biasanya lebih dari cukup (e.g. bank_transfer, echannel, qris)
            $table->string('payment_type', 50)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('donasis', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
};
