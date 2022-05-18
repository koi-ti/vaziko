<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion8', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden8_orden2')->unsigned();
            $table->string('orden8_archivo', 200);
            $table->datetime('orden8_fh_elaboro');
            $table->integer('orden8_usuario_elaboro')->unsigned();

            $table->foreign('orden8_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden8_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion8');
    }
}
