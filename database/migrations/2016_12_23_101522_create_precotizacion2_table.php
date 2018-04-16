<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion2', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion2_precotizacion1')->unsigned();
             $table->integer('precotizacion2_productop')->unsigned();
             $table->integer('precotizacion2_cantidad')->unsigned();

             $table->foreign('precotizacion2_precotizacion1')->references('id')->on('koi_precotizacion1')->onDelete('restrict');
             $table->foreign('precotizacion2_productop')->references('id')->on('koi_productop')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion2');
     }
}
