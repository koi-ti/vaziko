<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion4', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden4_orden2')->unsigned();
            $table->integer('orden4_materialp')->unsigned();
            $table->double('orden4_cantidad')->default(0);
            $table->double('orden4_precio')->default(0);
            $table->string('orden4_medidas', 50)->nullable();

            $table->foreign('orden4_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden4_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion4');
    }
}
