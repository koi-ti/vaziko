<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion9Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_cotizacion9', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('cotizacion9_cotizacion2')->unsigned();
             $table->integer('cotizacion9_producto')->unsigned();
             $table->string('cotizacion9_medidas', 50);
             $table->double('cotizacion9_cantidad')->default(0);
             $table->double('cotizacion9_valor_unitario')->default(0);
             $table->double('cotizacion9_valor_total')->default(0);
             $table->datetime('cotizacion9_fh_elaboro');
             $table->integer('cotizacion9_usuario_elaboro')->unsigned();

             $table->foreign('cotizacion9_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
             $table->foreign('cotizacion9_producto')->references('id')->on('koi_producto')->onDelete('restrict');
             $table->foreign('cotizacion9_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_cotizacion9');
     }
}
