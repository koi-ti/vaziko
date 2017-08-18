<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('koi_cotizacion4', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('cotizacion4_cotizacion2')->unsigned();
             $table->integer('cotizacion4_materialp')->unsigned();

             $table->foreign('cotizacion4_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
             $table->foreign('cotizacion4_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');

             $table->unique(['cotizacion4_cotizacion2', 'cotizacion4_materialp'], 'koi_cotizacion4_cotizacion2_materialp_unique');
         });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion4');
    }
}
