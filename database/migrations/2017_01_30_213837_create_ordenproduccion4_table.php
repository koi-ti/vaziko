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
            $table->integer('orden4_producto')->unsigned()->nullable();
            $table->string('orden4_medidas', 50)->nullable();
            $table->double('orden4_cantidad')->default(0);
            $table->double('orden4_valor_unitario')->default(0);
            $table->double('orden4_valor_total')->default(0);
            $table->datetime('orden4_fh_elaboro');
            $table->integer('orden4_usuario_elaboro')->unsigned();

            $table->foreign('orden4_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden4_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->foreign('orden4_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('orden4_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
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
