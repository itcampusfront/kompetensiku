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
        Schema::table('uji_soals', function (Blueprint $table) {
            $table->json('opsi_media')->nullable()->after('opsi_jawaban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uji_soals', function (Blueprint $table) {
            $table->dropColumn('opsi_media');
        });
    }
};