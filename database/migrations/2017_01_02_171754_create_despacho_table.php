<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespachoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_despachop1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('despachop1_orden')->unsigned();
            $table->integer('despachop1_contacto')->unsigned();
            $table->date('despachop1_fecha');
            $table->boolean('despachop1_anulado')->default(false);
            $table->text('despachop1_observacion')->nullable();
            $table->string('despachop1_transporte', 200)->nullable();

            $table->datetime('despachop1_fecha_elaboro');
            $table->integer('despachop1_usuario_elaboro')->unsigned();
            $table->datetime('despachop1_fecha_anulo')->nullable();
            $table->integer('despachop1_usuario_anulo')->nullable()->unsigned();

            $table->foreign('despachop1_orden')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
            $table->foreign('despachop1_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
            $table->foreign('despachop1_usuario_anulo')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('despachop1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_despachop1');
    }
}
