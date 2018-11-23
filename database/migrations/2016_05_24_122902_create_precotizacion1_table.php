<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion1', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion1_cliente')->unsigned();
             $table->integer('precotizacion1_contacto')->unsigned();
             $table->string('precotizacion1_suministran', 200)->nullable();
             $table->string('precotizacion1_referencia', 100);
             $table->integer('precotizacion1_numero')->default(0);
             $table->string('precotizacion1_ano', 4);
             $table->date('precotizacion1_fecha');
             $table->boolean('precotizacion1_abierta')->default(false);
             $table->boolean('precotizacion1_culminada')->default(false);
             $table->string('precotizacion1_observaciones');
             $table->datetime('precotizacion1_fh_culminada')->nullable();
             $table->integer('precotizacion1_usuario_culminada')->nullable()->unsigned();
             $table->datetime('precotizacion1_fh_elaboro');
             $table->integer('precotizacion1_usuario_elaboro')->unsigned();

             $table->foreign('precotizacion1_cliente')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('precotizacion1_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
             $table->foreign('precotizacion1_usuario_culminada')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('precotizacion1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion1');
     }
}
