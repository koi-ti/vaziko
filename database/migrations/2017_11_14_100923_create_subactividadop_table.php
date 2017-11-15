<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubactividadopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_subactividadop', function( Blueprint $table ){
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->string('subactividadop_nombre', 50);
             $table->integer('subactividadop_actividad')->unsigned();
             $table->boolean('subactividadop_activo')->default(false);

             $table->foreign('subactividadop_actividad')->references('id')->on('koi_actividadop')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_subactividadop');
     }
}
