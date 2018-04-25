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
            $table->integer('producto_referencia')->unsigned()->nullable()->comment = 'Codigo producto padre';
            $table->integer('producto_grupo')->unsigned();
            $table->integer('producto_subgrupo')->unsigned();
            $table->integer('producto_unidadmedida')->unsigned()->nullable();
            $table->integer('producto_materialp')->unsigned()->nullable();
            $table->double('producto_precio')->default(0);
            $table->double('producto_costo')->default(0);
            $table->integer('producto_vidautil')->nullable();
            $table->boolean('producto_unidades')->default(true)->comment = 'Si es falso no hace suma /resta de unidades, ni valida unidades en el inventario';
            $table->boolean('producto_serie')->default(false)->comment = 'El producto maneja serie';
            $table->boolean('producto_metrado')->default(false)->comment = 'El producto se va a vender por metros';
            $table->double('producto_ancho')->default(0)->comment = 'Cuando el producto es metrado';
            $table->double('producto_largo')->default(0)->comment = 'Cuando el producto es metrado';

            $table->foreign('producto_grupo')->references('id')->on('koi_grupo')->onDelete('restrict');
            $table->foreign('producto_subgrupo')->references('id')->on('koi_subgrupo')->onDelete('restrict');
            $table->foreign('producto_unidadmedida')->references('id')->on('koi_unidadmedida')->onDelete('restrict');
            $table->foreign('producto_referencia')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('producto_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
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
