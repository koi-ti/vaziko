<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_precotizacion8', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('precotizacion8_precotizacion2')->unsigned();
            $table->integer('precotizacion8_maquinap')->unsigned();

            $table->foreign('precotizacion8_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
            $table->foreign('precotizacion8_maquinap')->references('id')->on('koi_maquinap')->onDelete('restrict');

            $table->unique(['precotizacion8_precotizacion2', 'precotizacion8_maquinap'], 'koi_precotizacion8_precotizacion2_maquinap_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_precotizacion8');
    }
}
