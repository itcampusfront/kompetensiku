<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPendaftarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            // Menambahkan kolom status, enum ('Diterima', 'Ditolak'), default NULL
            // Diletakkan setelah kolom file_portofolio_pengalaman (atau sesuaikan dengan urutan kolom Anda)
            $table->enum('status', ['Diterima', 'Ditolak'])->nullable()->default(null)->after('file_portofolio_pengalaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}