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
            $table->integer('prodboderollo_item');
            $table->double('prodboderollo_metros')->default(0);
            $table->double('prodboderollo_saldo')->default(0);
            $table->double('prodboderollo_costo')->default(0)->comment = 'Costo por metro (Costo total del rollo / # metros)';

            $table->foreign('prodboderollo_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('prodboderollo_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->unique(['prodboderollo_producto', 'prodboderollo_sucursal', 'prodboderollo_item'], 'koi_prodboderollo_producto_sucursal_item_unique');
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
