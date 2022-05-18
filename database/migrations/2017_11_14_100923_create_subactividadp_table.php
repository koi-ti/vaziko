<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubactividadpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_subactividadp', function( Blueprint $table ){
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->string('subactividadp_nombre', 50);
             $table->integer('subactividadp_actividadp')->unsigned();
             $table->boolean('subactividadp_activo')->default(false);

             $table->foreign('subactividadp_actividadp')->references('id')->on('koi_actividadp')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_subactividadp');
     }
}
