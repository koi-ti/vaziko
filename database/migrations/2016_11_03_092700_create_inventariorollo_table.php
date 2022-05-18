<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariorolloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_inventariorollo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventariorollo_inventario')->unsigned();
            $table->integer('inventariorollo_item');
            $table->double('inventariorollo_metros_entrada')->default(0);
            $table->double('inventariorollo_metros_salida')->default(0);
            $table->double('inventariorollo_costo')->default(0);

            $table->foreign('inventariorollo_inventario')->references('id')->on('koi_inventario')->onDelete('restrict');
            $table->unique(['inventariorollo_inventario', 'inventariorollo_item'], 'koi_inventariorollo_inventario_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_inventariorollo');
    }
}
