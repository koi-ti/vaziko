<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerceroimagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_terceroimagen', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('terceroimagen_tercero')->unsigned();
            $table->string('terceroimagen_archivo', 200);
            $table->datetime('terceroimagen_fh_elaboro');
            $table->integer('terceroimagen_usuario_elaboro')->unsigned();

            $table->foreign('terceroimagen_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('terceroimagen_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_terceroimagen');
    }
}
