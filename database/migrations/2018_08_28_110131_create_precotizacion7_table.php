<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion7Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_precotizacion7', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('precotizacion7_precotizacion2')->unsigned();
            $table->integer('precotizacion7_acabadop')->unsigned();

            $table->foreign('precotizacion7_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
            $table->foreign('precotizacion7_acabadop')->references('id')->on('koi_acabadop')->onDelete('restrict');

            $table->unique(['precotizacion7_precotizacion2', 'precotizacion7_acabadop'], 'koi_precotizacion7_precotizacion2_acabadop_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('koi_precotizacion7');
    }
}
