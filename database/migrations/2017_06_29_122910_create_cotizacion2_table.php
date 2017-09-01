<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion2', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion2_cotizacion')->unsigned();
            $table->integer('cotizacion2_productop')->unsigned();
            $table->string('cotizacion2_referencia', 200);
            $table->integer('cotizacion2_cantidad')->default(0);
            $table->integer('cotizacion2_saldo')->default(0);
            $table->integer('cotizacion2_facturado')->default(0);
            $table->text('cotizacion2_precio_formula');
            $table->string('cotizacion2_round_formula', 10);
            $table->double('cotizacion2_viaticos')->default(0);
            $table->integer('cotizacion2_transporte')->default(0);
            $table->double('cotizacion2_precio_venta')->default(0);
            $table->integer('cotizacion2_entregado')->default(0);
            $table->text('cotizacion2_observaciones')->nullable();

            $table->boolean('cotizacion2_tiro')->default(false);
            $table->boolean('cotizacion2_retiro')->default(false);

            $table->boolean('cotizacion2_yellow')->default(false);
            $table->boolean('cotizacion2_magenta')->default(false);
            $table->boolean('cotizacion2_cyan')->default(false);
            $table->boolean('cotizacion2_key')->default(false);
            $table->boolean('cotizacion2_color1')->default(false);
            $table->boolean('cotizacion2_color2')->default(false);
            $table->text('cotizacion2_nota_tiro')->nullable();

            $table->boolean('cotizacion2_yellow2')->default(false);
            $table->boolean('cotizacion2_magenta2')->default(false);
            $table->boolean('cotizacion2_cyan2')->default(false);
            $table->boolean('cotizacion2_key2')->default(false);
            $table->boolean('cotizacion2_color12')->default(false);
            $table->boolean('cotizacion2_color22')->default(false);
            $table->text('cotizacion2_nota_retiro')->nullable();

            $table->double('cotizacion2_ancho')->default(0);
            $table->double('cotizacion2_alto')->default(0);
            $table->double('cotizacion2_c_ancho')->default(0);
            $table->double('cotizacion2_c_alto')->default(0);
            $table->double('cotizacion2_3d_ancho')->default(0);
            $table->double('cotizacion2_3d_alto')->default(0);
            $table->double('cotizacion2_3d_profundidad')->default(0);

            $table->datetime('cotizacion2_fecha_elaboro');
            $table->integer('cotizacion2_usuario_elaboro')->unsigned();

            $table->foreign('cotizacion2_cotizacion')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
            $table->foreign('cotizacion2_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('cotizacion2_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion2');
    }
}
