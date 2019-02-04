<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden2_orden')->unsigned();
            $table->integer('orden2_productop')->unsigned();
            $table->string('orden2_referencia', 200);
            $table->integer('orden2_cantidad')->default(0);
            $table->integer('orden2_saldo')->default(0);
            $table->integer('orden2_facturado')->default(0);
            $table->text('orden2_precio_formula');
            $table->text('orden2_transporte_formula');
            $table->text('orden2_viaticos_formula');
            $table->double('orden2_viaticos')->default(0);
            $table->integer('orden2_transporte')->default(0);
            $table->double('orden2_precio_venta')->default(0);
            $table->double('orden2_total_valor_unitario')->default(0);
            $table->integer('orden2_entregado')->default(0);
            $table->text('orden2_observaciones')->nullable();

            $table->boolean('orden2_tiro')->default(false);
            $table->boolean('orden2_retiro')->default(false);

            $table->integer('orden2_volumen')->default(0);
            $table->integer('orden2_round')->default(0);
            $table->double('orden2_vtotal')->default(0);

            $table->double('orden2_margen_materialp')->default(0);
            $table->double('orden2_margen_empaque')->default(0);

            $table->boolean('orden2_yellow')->default(false);
            $table->boolean('orden2_magenta')->default(false);
            $table->boolean('orden2_cyan')->default(false);
            $table->boolean('orden2_key')->default(false);
            $table->boolean('orden2_color1')->default(false);
            $table->boolean('orden2_color2')->default(false);
            $table->text('orden2_nota_tiro')->nullable();

            $table->boolean('orden2_yellow2')->default(false);
            $table->boolean('orden2_magenta2')->default(false);
            $table->boolean('orden2_cyan2')->default(false);
            $table->boolean('orden2_key2')->default(false);
            $table->boolean('orden2_color12')->default(false);
            $table->boolean('orden2_color22')->default(false);
            $table->text('orden2_nota_retiro')->nullable();

            $table->double('orden2_ancho')->default(0);
            $table->double('orden2_alto')->default(0);
            $table->double('orden2_c_ancho')->default(0);
            $table->double('orden2_c_alto')->default(0);
            $table->double('orden2_3d_ancho')->default(0);
            $table->double('orden2_3d_alto')->default(0);
            $table->double('orden2_3d_profundidad')->default(0);

            $table->datetime('orden2_fecha_elaboro');
            $table->integer('orden2_usuario_elaboro')->unsigned();

            $table->foreign('orden2_orden')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
            $table->foreign('orden2_productop')->references('id')->on('koi_productop')->onDelete('restrict');
            $table->foreign('orden2_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion2');
    }
}
