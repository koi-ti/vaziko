<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_factura1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->date('factura1_fecha');
            $table->date('factura1_fecha_vencimiento');
            $table->integer('factura1_puntoventa')->unsigned();
            $table->integer('factura1_orden')->unsigned();
            $table->double('factura1_valor')->default(0);

            $table->foreign('factura1_puntoventa')->references('id')->on('koi_puntoventa')->onDelete('restrict');
            $table->foreign('factura1_orden')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_factura1');
    }
}
