<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdboderolloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_prodboderollo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('prodboderollo_producto')->unsigned();
            $table->integer('prodboderollo_sucursal')->unsigned();
            $table->double('prodboderollo_centimetro')->default(0);
            $table->double('prodboderollo_saldo')->default(0);

            $table->foreign('prodboderollo_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('prodboderollo_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_prodboderollo');
    }
}
