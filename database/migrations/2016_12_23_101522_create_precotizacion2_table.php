<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('koi_precotizacion2', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->integer('precotizacion2_precotizacion1')->unsigned();
             $table->integer('precotizacion2_productop')->unsigned();
             $table->string('precotizacion2_referencia', 200);
             $table->integer('precotizacion2_cantidad')->unsigned();

             $table->boolean('precotizacion2_tiro')->default(false);
             $table->boolean('precotizacion2_retiro')->default(false);

             $table->boolean('precotizacion2_yellow')->default(false);
             $table->boolean('precotizacion2_magenta')->default(false);
             $table->boolean('precotizacion2_cyan')->default(false);
             $table->boolean('precotizacion2_key')->default(false);
             $table->boolean('precotizacion2_color1')->default(false);
             $table->boolean('precotizacion2_color2')->default(false);
             $table->text('precotizacion2_nota_tiro')->nullable();

             $table->boolean('precotizacion2_yellow2')->default(false);
             $table->boolean('precotizacion2_magenta2')->default(false);
             $table->boolean('precotizacion2_cyan2')->default(false);
             $table->boolean('precotizacion2_key2')->default(false);
             $table->boolean('precotizacion2_color12')->default(false);
             $table->boolean('precotizacion2_color22')->default(false);
             $table->text('precotizacion2_nota_retiro')->nullable();

             $table->double('precotizacion2_ancho')->default(0);
             $table->double('precotizacion2_alto')->default(0);
             $table->double('precotizacion2_c_ancho')->default(0);
             $table->double('precotizacion2_c_alto')->default(0);
             $table->double('precotizacion2_3d_ancho')->default(0);
             $table->double('precotizacion2_3d_alto')->default(0);
             $table->double('precotizacion2_3d_profundidad')->default(0);

             $table->text('precotizacion2_observaciones')->nullable();

             $table->foreign('precotizacion2_precotizacion1')->references('id')->on('koi_precotizacion1')->onDelete('restrict');
             $table->foreign('precotizacion2_productop')->references('id')->on('koi_productop')->onDelete('restrict');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('koi_precotizacion2');
     }
}
