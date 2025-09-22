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
            Schema::table('donasis', function (Blueprint $table) {
                // Tambahkan kolom baru untuk menyimpan metode pembayaran setelah kolom 'status'
                $table->string('metode_pembayaran')->nullable()->after('status');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('donasis', function (Blueprint $table) {
                // Perintah untuk menghapus kolom jika migrasi di-rollback
                $table->dropColumn('metode_pembayaran');
            });
        }
    };