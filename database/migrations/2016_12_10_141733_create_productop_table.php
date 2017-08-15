<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_productop', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('productop_nombre', 250);
            $table->text('productop_observaciones')->nullable();
            $table->datetime('productop_fecha_elaboro');
            $table->integer('productop_usuario_elaboro')->unsigned();

            $table->boolean('productop_tiro')->default(false);
            $table->boolean('productop_retiro')->default(false);

            $table->integer('productop_ancho_med')->unsigned()->nullable();
            $table->integer('productop_alto_med')->unsigned()->nullable();
            $table->integer('productop_c_med_ancho')->unsigned()->nullable();
            $table->integer('productop_c_med_alto')->unsigned()->nullable();
            $table->integer('productop_tipoproductop')->unsigned();

            $table->boolean('productop_abierto')->default(false);
            $table->boolean('productop_cerrado')->default(false);
            $table->boolean('productop_3d')->default(false);

            $table->integer('productop_3d_profundidad_med')->unsigned()->nullable();
            $table->integer('productop_3d_ancho_med')->unsigned()->nullable();
            $table->integer('productop_3d_alto_med')->unsigned()->nullable();

            $table->foreign('productop_ancho_med')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_alto_med')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_c_med_ancho')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_c_med_alto')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_3d_profundidad_med')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_3d_ancho_med')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_3d_alto_med')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('productop_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('productop_tipoproductop')->references('id')->on('koi_tipoproductop')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_productop');
    }
}
