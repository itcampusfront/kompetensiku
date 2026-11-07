<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkemaUksTable extends Migration
{
    public function up()
    {
        Schema::create('skema_uks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_uji_id')->constrained('skema_ujis')->onDelete('cascade');
            $table->string('kode');
            $table->string('judul');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema_uks');
    }
}