<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccionimagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccionimagen', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ordenimagen_orden')->unsigned();
            $table->string('ordenimagen_archivo', 200);
            $table->datetime('ordenimagen_fh_elaboro');
            $table->integer('ordenimagen_usuario_elaboro')->unsigned();

            $table->foreign('ordenimagen_orden')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
            $table->foreign('ordenimagen_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccionimagen');
    }
}
