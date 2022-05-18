<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion4', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion4_precotizacion2')->unsigned();
             $table->string('precotizacion4_archivo', 200);
             $table->datetime('precotizacion4_fh_elaboro');
             $table->integer('precotizacion4_usuario_elaboro')->unsigned();

             $table->foreign('precotizacion4_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
             $table->foreign('precotizacion4_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion4');
     }
}
