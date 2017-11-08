<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion6', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden6_orden2')->unsigned();
            $table->integer('orden6_areap')->unsigned()->nullable();
            $table->string('orden6_nombre', 20)->nullable();
            $table->time('orden6_horas');
            $table->double('orden6_valor')->default(0);

            $table->foreign('orden6_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden6_areap')->references('id')->on('koi_areap')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion6');
    }
}
