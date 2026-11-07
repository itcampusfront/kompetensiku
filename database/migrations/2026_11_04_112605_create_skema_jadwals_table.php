<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkemaJadwalsTable extends Migration
{
    public function up()
    {
        Schema::create('skema_jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_uji_id')->constrained('skema_ujis')->onDelete('cascade');
            $table->string('nama_jadwal');
            $table->text('deskripsi')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('status')->default('Buka'); // Contoh: Buka / Tutup
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema_jadwals');
    }
}