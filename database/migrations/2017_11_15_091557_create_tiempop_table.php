<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiempopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_tiempop', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('tiempop_ordenp')->unsigned()->nullable();
             $table->integer('tiempop_tercero')->unsigned();
             $table->integer('tiempop_areap')->unsigned();
             $table->integer('tiempop_actividadp')->unsigned()->nullable();
             $table->integer('tiempop_subactividadp')->unsigned()->nullable();
             $table->date('tiempop_fecha');
             $table->time('tiempop_hora_inicio');
             $table->time('tiempop_hora_fin');
             $table->datetime('tiempop_fh_elaboro');

             $table->foreign('tiempop_ordenp')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
             $table->foreign('tiempop_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
             $table->foreign('tiempop_areap')->references('id')->on('koi_areap')->onDelete('restrict');
             $table->foreign('tiempop_actividadp')->references('id')->on('koi_actividadp')->onDelete('restrict');
             $table->foreign('tiempop_subactividadp')->references('id')->on('koi_subactividadp')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_tiempop');
     }
}
