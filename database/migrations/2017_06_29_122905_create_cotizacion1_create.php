<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion1Create extends Migration
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
            $table->integer('cotizacion1_numero')->default(0);
            $table->integer('cotizacion1_ano')->default(0);
            $table->integer('cotizacion1_cliente')->unsigned();
            $table->integer('cotizacion1_contacto')->unsigned();
            $table->date('cotizacion1_fecha');
            $table->date('cotizacion1_entrega');
            $table->text('cotizacion1_descripcion');
            $table->boolean('cotizacion1_aprobada')->default(false);
            $table->boolean('cotizacion1_anulada')->default(false);
            $table->integer('cotizacion1_usuario_elaboro')->unsigned();
            $table->dateTime('cotizacion1_fh_elaboro');

            $table->foreign('cotizacion1_cliente')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('cotizacion1_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
            $table->foreign('cotizacion1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
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
