<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion5', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden5_orden2')->unsigned();
            $table->integer('orden5_acabadop')->unsigned();

            $table->foreign('orden5_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden5_acabadop')->references('id')->on('koi_acabadop')->onDelete('restrict');

            $table->unique(['orden5_orden2', 'orden5_acabadop']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion5');
    }
}
