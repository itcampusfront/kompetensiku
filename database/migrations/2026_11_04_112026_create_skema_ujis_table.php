<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkemaUjisTable extends Migration
{
    public function up()
    {
        Schema::create('skema_ujis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_skema');
            $table->string('status')->default('Aktif'); // Contoh: Aktif / Tidak Aktif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema_ujis');
    }
}