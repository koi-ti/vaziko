<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductop4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productop4', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productop4_productop')->unsigned();
            $table->integer('productop4_maquinap')->unsigned();

            $table->foreign('productop4_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('productop4_maquinap')->references('id')->on('koi_maquinap')->onDelete('restrict');
            $table->unique(['productop4_productop', 'productop4_maquinap']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productop4');
    }
}
