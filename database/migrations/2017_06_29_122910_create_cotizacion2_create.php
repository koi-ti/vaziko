<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion2Create extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion2', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion2_cotizacion1')->unsigned();
            $table->string('cotizacion2_productoc', 200);
            $table->integer('cotizacion2_materialp')->unsigned()->nullable();
            $table->string('cotizacion2_medida', 25);
            $table->double('cotizacion2_cantidad')->default(0);
            $table->double('cotizacion2_valor')->default(0);

            $table->foreign('cotizacion2_cotizacion1')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
            $table->foreign('cotizacion2_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion2');
    }
}
