<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespachocotizacion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_despachocotizacion2', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('despachoc2_despacho')->unsigned();
             $table->integer('despachoc2_cotizacion2')->unsigned();
             $table->integer('despachoc2_cantidad')->default(0);

             $table->foreign('despachoc2_despacho')->references('id')->on('koi_despachocotizacion1')->onDelete('restrict');
             $table->foreign('despachoc2_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_despachocotizacion2');
     }
}
