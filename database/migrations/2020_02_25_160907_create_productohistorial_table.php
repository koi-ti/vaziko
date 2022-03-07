<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductohistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_productohistorial', function (Blueprint $table) {
             $table->increments('id');
             $table->enum('productohistorial_tipo', ['M', 'E', 'T'])->comment('Material,Empaque,Transporte');
             $table->enum('productohistorial_modulo', ['C', 'O'])->comment('Cotizacion,Orden');
             $table->integer('productohistorial_producto');
             $table->double('productohistorial_valor')->default(0);
             $table->datetime('productohistorial_fh_elaboro');
             $table->integer('numero_modulo');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_productohistorial');
     }
}
