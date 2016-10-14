<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_producto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('producto_nombre', 200);
            $table->string('producto_codigo', 15);
            $table->string('producto_codigoori', 15)->comment = 'Codigo que la da el proveedor a ese producto';
            $table->string('producto_referencia', 15)->comment = 'Si no tiene serie entonces es igual a producto_codigo, si no es la referencia de producto_codigo (El padre)';
            $table->integer('producto_grupo')->unsigned();
            $table->integer('producto_subgrupo')->unsigned();
            $table->double('producto_precio')->default(0);
            $table->double('producto_costo')->default(0);
            $table->boolean('producto_unidades')->default(true);

            $table->foreign('producto_grupo')->references('id')->on('koi_grupo')->onDelete('restrict');
            $table->foreign('producto_subgrupo')->references('id')->on('koi_subgrupo')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_producto');
    }
}
