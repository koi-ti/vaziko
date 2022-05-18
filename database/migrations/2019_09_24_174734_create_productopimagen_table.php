<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductopimagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productopimagen', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productopimagen_productop')->unsigned();
            $table->string('productopimagen_archivo', 200);
            $table->datetime('productopimagen_fh_elaboro');
            $table->integer('productopimagen_usuario_elaboro')->unsigned();

            $table->foreign('productopimagen_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('productopimagen_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productopimagen');
    }
}
