<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion1', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion1_cliente')->unsigned();
            $table->string('cotizacion1_referencia', 200);
            $table->integer('cotizacion1_numero');
            $table->integer('cotizacion1_ano');
            $table->date('cotizacion1_fecha_inicio');
            $table->integer('cotizacion1_contacto')->unsigned();
            $table->integer('cotizacion1_iva')->unsigned();
            $table->string('cotizacion1_suministran', 200)->nullable();
            $table->boolean('cotizacion1_anulada')->default(false);
            $table->boolean('cotizacion1_abierta')->default(true);
            $table->text('cotizacion1_observaciones')->nullable();
            $table->text('cotizacion1_terminado')->nullable();
            $table->datetime('cotizacion1_fecha_elaboro');
            $table->integer('cotizacion1_usuario_elaboro')->unsigned();
            $table->datetime('cotizacion1_fecha_anulo')->nullable();
            $table->integer('cotizacion1_usuario_anulo')->nullable()->unsigned();

            $table->foreign('cotizacion1_cliente')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('cotizacion1_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
            $table->foreign('cotizacion1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('cotizacion1_usuario_anulo')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->unique(['cotizacion1_numero', 'cotizacion1_ano']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion1');
    }
}
