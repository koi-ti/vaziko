<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionarchivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_cotizacionarchivo', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('cotizacionarchivo_cotizacion')->unsigned();
             $table->string('cotizacionarchivo_archivo', 200);
             $table->datetime('cotizacionarchivo_fh_elaboro');
             $table->integer('cotizacionarchivo_usuario_elaboro')->unsigned();

             $table->foreign('cotizacionarchivo_cotizacion')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
             $table->foreign('cotizacionarchivo_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_cotizacionarchivo');
     }
}
