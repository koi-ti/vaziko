<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_notificaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('notificacion_tercero');
            $table->string('notificacion_titulo', 50);
            $table->text('notificacion_descripcion');
            $table->dateTime('notificacion_fh');
            $table->boolean('notificacion_visto')->default(false);
            $table->dateTime('notificacion_fh_visto')->nullable();

            $table->foreign('notificacion_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_notificaciones');
    }
}
