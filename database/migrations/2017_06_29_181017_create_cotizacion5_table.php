<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_cotizacion5', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('cotizacion5_cotizacion2')->unsigned();
             $table->integer('cotizacion5_acabadop')->unsigned();

             $table->foreign('cotizacion5_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
             $table->foreign('cotizacion5_acabadop')->references('id')->on('koi_acabadop')->onDelete('restrict');

             $table->unique(['cotizacion5_cotizacion2', 'cotizacion5_acabadop'], 'koi_cotizacion5_cotizacion2_acabadop_unique');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_cotizacion5');
     }
}
