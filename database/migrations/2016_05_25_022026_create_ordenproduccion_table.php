<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden_cliente')->unsigned();
            $table->string('orden_referencia', 200);
            $table->integer('orden_numero');
            $table->integer('orden_ano');
            $table->date('orden_fecha_inicio');
            $table->date('orden_fecha_entrega');
            $table->time('orden_hora_entrega');
            $table->integer('orden_contacto')->unsigned();
            $table->integer('orden_cotizacion')->unsigned()->nullable();
            $table->integer('orden_iva')->unsigned();
            $table->string('orden_formapago', 30)->comment = 'Lo que posea el tercero';
            $table->string('orden_suministran', 200)->nullable();
            $table->boolean('orden_anulada')->default(false);
            $table->boolean('orden_culminada')->default(false);
            $table->boolean('orden_abierta')->default(true);
            $table->date('orden_fecha_recogida1')->nullable();
            $table->date('orden_fecha_recogida2')->nullable();
            $table->time('orden_hora_recogida1')->nullable();
            $table->time('orden_hora_recogida2')->nullable();
            $table->boolean('orden_estado_recogida1')->default(true);
            $table->boolean('orden_estado_recogida2')->default(true);
            $table->text('orden_observaciones')->nullable();
            $table->text('orden_terminado')->nullable();
            $table->text('orden_observaciones_archivo')->nullable();
            $table->integer('orden_vendedor')->unsigned()->nullable();
            $table->datetime('orden_fecha_elaboro');
            $table->integer('orden_usuario_elaboro')->unsigned();
            $table->datetime('orden_fecha_anulo')->nullable();
            $table->integer('orden_usuario_anulo')->nullable()->unsigned();

            $table->foreign('orden_cliente')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('orden_contacto')->references('id')->on('koi_tcontacto')->onDelete('restrict');
            $table->foreign('orden_cotizacion')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
            $table->foreign('orden_vendedor')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('orden_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('orden_usuario_anulo')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->unique(['orden_numero', 'orden_ano']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion');
    }
}
