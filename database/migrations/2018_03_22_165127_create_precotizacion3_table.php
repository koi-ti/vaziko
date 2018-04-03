<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion3', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion3_precotizacion2')->unsigned();
             $table->integer('precotizacion3_productop')->unsigned();
             $table->integer('precotizacion3_materialp')->unsigned();
             $table->integer('precotizacion3_proveedor')->unsigned();
             $table->integer('precotizacion3_cantidad')->default(0);
             $table->string('precotizacion3_medidas', 50);
             $table->double('precotizacion3_valor_unitario')->default(0);
             $table->double('precotizacion3_valor_total')->default(0);
             $table->datetime('precotizacion3_fh_elaboro');
             $table->integer('precotizacion3_usuario_elaboro')->unsigned();

             $table->foreign('precotizacion3_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
             $table->foreign('precotizacion3_productop')->references('id')->on('koi_productop')->onDelete('restrict');
             $table->foreign('precotizacion3_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
             $table->foreign('precotizacion3_proveedor')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('precotizacion3_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion3');
     }
}
