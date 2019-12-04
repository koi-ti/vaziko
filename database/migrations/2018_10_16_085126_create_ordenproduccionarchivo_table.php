<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccionarchivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccionarchivo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ordenarchivo_orden')->unsigned();
            $table->string('ordenarchivo_archivo', 200);
            $table->datetime('ordenarchivo_fh_elaboro');
            $table->integer('ordenarchivo_usuario_elaboro')->unsigned();

            $table->foreign('ordenarchivo_orden')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
            $table->foreign('ordenarchivo_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccionarchivo');
    }
}
