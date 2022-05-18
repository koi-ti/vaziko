<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion3', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion3_cotizacion2')->unsigned();
            $table->integer('cotizacion3_maquinap')->unsigned();

            $table->foreign('cotizacion3_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
            $table->foreign('cotizacion3_maquinap')->references('id')->on('koi_maquinap')->onDelete('restrict');

            $table->unique(['cotizacion3_cotizacion2', 'cotizacion3_maquinap'], 'koi_cotizacion3_cotizacion2_maquinap_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion3');
    }
}
