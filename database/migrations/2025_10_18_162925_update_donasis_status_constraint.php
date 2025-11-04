<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Hapus constraint lama jika ada
        DB::statement("ALTER TABLE donasis DROP CONSTRAINT IF EXISTS donasis_status_check");

        // Tambah constraint baru dengan nilai yang diizinkan
        DB::statement("
            ALTER TABLE donasis
            ADD CONSTRAINT donasis_status_check
            CHECK (status IN ('pending','success','failed','expired','refunded'))
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE donasis DROP CONSTRAINT IF EXISTS donasis_status_check");
        DB::statement("
            ALTER TABLE donasis
            ADD CONSTRAINT donasis_status_check
            CHECK (status IN ('pending','success','failed'))
        ");
    }
};
