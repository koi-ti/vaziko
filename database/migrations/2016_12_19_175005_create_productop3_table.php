<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductop3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productop3', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productop3_productop')->unsigned();
            $table->integer('productop3_areap')->unsigned();

            $table->foreign('productop3_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('productop3_areap')->references('id')->on('koi_areap')->onDelete('restrict');
            $table->unique(['productop3_productop', 'productop3_areap']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productop3');
    }
}
