<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_factura2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('factura2_factura1')->unsigned();
            $table->integer('factura2_orden2')->unsigned();
            $table->integer('factura2_cantidad')->default(0);

            $table->foreign('factura2_factura1')->references('id')->on('koi_factura1')->onDelete('restrict');
            $table->foreign('factura2_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_factura2');
    }
}
