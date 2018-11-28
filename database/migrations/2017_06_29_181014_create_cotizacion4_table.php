<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('koi_cotizacion4', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('cotizacion4_cotizacion2')->unsigned();
             $table->integer('cotizacion4_materialp')->unsigned();
             $table->integer('cotizacion4_producto')->unsigned()->nullable();
             $table->double('cotizacion4_cantidad')->default(0);
             $table->string('cotizacion4_medidas', 50)->nullable();
             $table->double('cotizacion4_valor_unitario')->default(0);
             $table->double('cotizacion4_valor_total')->default(0);
             $table->datetime('cotizacion4_fh_elaboro');
             $table->integer('cotizacion4_usuario_elaboro')->unsigned();

             $table->foreign('cotizacion4_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
             $table->foreign('cotizacion4_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
             $table->foreign('cotizacion4_producto')->references('id')->on('koi_producto')->onDelete('restrict');
             $table->foreign('cotizacion4_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
         });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion4');
    }
}
