<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeToProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program', function (Blueprint $table) {
            if(!Schema::hasColumn('program','program_materi')){
                $table->text('program_materi');
            }
            if(!Schema::hasColumn('program','materi_desk')){
                $table->text('materi_desk');
            }
            if(!Schema::hasColumn('program','program_manfaat')){
                $table->text('program_manfaat');
            }
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            //
        });
    }
}
