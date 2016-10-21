<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraslado2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_traslado2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('traslado2_traslado')->unsigned();
            $table->integer('traslado2_producto')->unsigned();
            $table->integer('traslado2_cantidad');
            $table->integer('traslado2_itemrollo');
            $table->double('traslado2_costo')->default(0);

            $table->foreign('traslado2_traslado')->references('id')->on('koi_traslado1')->onDelete('restrict');
            $table->foreign('traslado2_producto')->references('id')->on('koi_producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_traslado2');
    }
}
