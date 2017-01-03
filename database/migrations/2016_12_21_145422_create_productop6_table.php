<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductop6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productop6', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productop6_productop')->unsigned();
            $table->integer('productop6_acabadop')->unsigned();

            $table->foreign('productop6_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('productop6_acabadop')->references('id')->on('koi_acabadop')->onDelete('restrict');
            $table->unique(['productop6_productop', 'productop6_acabadop']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productop6');
    }
}
