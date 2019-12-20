<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_bitacora', function (Blueprint $table) {
             $table->increments('id');
             $table->morphs('bitacora');
             $table->enum('bitacora_accion', ['C', 'U', 'D']);
             $table->string('bitacora_modulo', 100);
             $table->longText('bitacora_cambios');
             $table->string('bitacora_ip', 20)->nullable();
             $table->datetime('bitacora_fh_elaboro');
             $table->unsignedInteger('bitacora_usuario_elaboro');

             $table->foreign('bitacora_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('cascade');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_bitacora');
     }
}
