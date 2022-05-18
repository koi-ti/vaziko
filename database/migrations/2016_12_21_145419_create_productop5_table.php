<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductop5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productop5', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productop5_productop')->unsigned();
            $table->integer('productop5_materialp')->unsigned();

            $table->foreign('productop5_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('productop5_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->unique(['productop5_productop', 'productop5_materialp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productop5');
    }
}
