<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtipoproductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_subtipoproductop', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->string('subtipoproductop_nombre', 25);
             $table->integer('subtipoproductop_tipoproductop')->unsigned();
             $table->boolean('subtipoproductop_activo')->default(false);

             $table->foreign('subtipoproductop_tipoproductop')->references('id')->on('koi_tipoproductop')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_subtipoproductop');
     }
}
