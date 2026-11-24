<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('uji_soals')) {
            // Mengubah kolom tipe dari ENUM lama menjadi VARCHAR(30)
            // agar mendukung 'pg', 'pg_kompleks', 'benar_salah', dan 'esai'
            DB::statement("ALTER TABLE `uji_soals` MODIFY `tipe` VARCHAR(30) NOT NULL DEFAULT 'pg'");

            // Tambahkan kolom opsi_media (JSON) jika belum tersedia
            Schema::table('uji_soals', function (Blueprint $table) {
                if (!Schema::hasColumn('uji_soals', 'opsi_media')) {
                    $table->json('opsi_media')->nullable()->after('opsi_jawaban');
                }
            });
        }

        if (Schema::hasTable('uji_hasils')) {
            // Tambahkan kolom nama_peserta_publik jika belum tersedia
            Schema::table('uji_hasils', function (Blueprint $table) {
                if (!Schema::hasColumn('uji_hasils', 'nama_peserta_publik')) {
                    $table->string('nama_peserta_publik')->nullable()->after('asesi_id');
                }
            });

            // Pastikan asesi_id boleh NULL untuk peserta umum tanpa login
            DB::statement("ALTER TABLE `uji_hasils` MODIFY `asesi_id` BIGINT UNSIGNED NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('uji_soals')) {
            Schema::table('uji_soals', function (Blueprint $table) {
                if (Schema::hasColumn('uji_soals', 'opsi_media')) {
                    $table->dropColumn('opsi_media');
                }
            });
        }
    }
};