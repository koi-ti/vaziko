<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiempoordenpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_tiempoordenp', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('tiempoordenp_ordenp')->unsigned();
             $table->integer('tiempoordenp_tercero')->unsigned();
             $table->integer('tiempoordenp_areap')->unsigned();
             $table->integer('tiempoordenp_actividadop')->unsigned()->nullable();
             $table->integer('tiempoordenp_subactividadop')->unsigned()->nullable();
             $table->date('tiempoordenp_fecha');
             $table->time('tiempoordenp_hora_inicio');
             $table->time('tiempoordenp_hora_fin');
             $table->datetime('tiempoordenp_fh_elaboro');

             $table->foreign('tiempoordenp_ordenp')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
             $table->foreign('tiempoordenp_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('tiempoordenp_areap')->references('id')->on('koi_areap')->onDelete('restrict');
             $table->foreign('tiempoordenp_actividadop')->references('id')->on('koi_actividadop')->onDelete('restrict');
             $table->foreign('tiempoordenp_subactividadop')->references('id')->on('koi_subactividadop')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_tiempoordenp');
     }
}
