<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion7Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion7', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden7_orden2')->unsigned();
            $table->string('orden7_texto', 200);
            $table->string('orden7_ancho', 10);
            $table->string('orden7_alto', 10);

            $table->foreign('orden7_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion7');
    }
}
