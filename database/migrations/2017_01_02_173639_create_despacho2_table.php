<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespacho2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_despachop2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('despachop2_despacho')->unsigned();
            $table->integer('despachop2_orden2')->unsigned();
            $table->integer('despachop2_cantidad')->default(0);

            $table->foreign('despachop2_despacho')->references('id')->on('koi_despachop1')->onDelete('restrict');
            $table->foreign('despachop2_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_despachop2');
    }
}
