<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion3', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden3_orden2')->unsigned();
            $table->integer('orden3_maquinap')->unsigned();

            $table->foreign('orden3_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden3_maquinap')->references('id')->on('koi_maquinap')->onDelete('restrict');

            $table->unique(['orden3_orden2', 'orden3_maquinap']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion3');
    }
}
