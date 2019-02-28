<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion9Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion9', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion9_precotizacion2')->unsigned();
             $table->integer('precotizacion9_producto')->unsigned();
             $table->string('precotizacion9_medidas', 50);
             $table->double('precotizacion9_cantidad')->default(0);
             $table->double('precotizacion9_valor_unitario')->default(0);
             $table->double('precotizacion9_valor_total')->default(0);
             $table->datetime('precotizacion9_fh_elaboro');
             $table->integer('precotizacion9_usuario_elaboro')->unsigned();

             $table->foreign('precotizacion9_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
             $table->foreign('precotizacion9_producto')->references('id')->on('koi_producto')->onDelete('restrict');
             $table->foreign('precotizacion9_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion9');
     }
}
