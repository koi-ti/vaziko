<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespachocotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_despachocotizacion1', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('despachoc1_cotizacion')->unsigned();
             $table->integer('despachoc1_contacto')->unsigned();
             $table->date('despachoc1_fecha');
             $table->boolean('despachoc1_anulado')->default(false);
             $table->text('despachoc1_observacion')->nullable();
             $table->string('despachoc1_transporte', 200)->nullable();

             $table->datetime('despachoc1_fecha_elaboro');
             $table->integer('despachoc1_usuario_elaboro')->unsigned();
             $table->datetime('despachoc1_fecha_anulo')->nullable();
             $table->integer('despachoc1_usuario_anulo')->nullable()->unsigned();

             $table->foreign('despachoc1_cotizacion')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
             $table->foreign('despachoc1_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
             $table->foreign('despachoc1_usuario_anulo')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('despachoc1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_despachocotizacion1');
     }
}
