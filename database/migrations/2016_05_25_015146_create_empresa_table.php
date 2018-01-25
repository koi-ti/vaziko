<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_empresa', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('empresa_tercero')->unsigned();
            $table->string('empresa_cc_representante', 15)->nullable();
            $table->string('empresa_nm_representante', 200)->nullable();
            $table->integer('empresa_niif')->nullable()->comment = '1 - Plena, 2 - Pymes, 3 - Micro pymes';
            $table->integer('empresa_iva')->unsigned();
            $table->string('empresa_cc_contador', 15)->nullable();
            $table->double('empresa_base_ica_compras')->default(0);
            $table->double('empresa_base_ica_servicios')->default(0);
            $table->double('empresa_base_retefuente_factura')->default(0);
            $table->double('empresa_porcentaje_retefuente_factura')->default(0);
            $table->double('empresa_base_reteiva_factura')->default(0);
            $table->double('empresa_porcentaje_reteiva_factura')->default(0);
            $table->string('empresa_tj_contador', 15)->nullable();
            $table->string('empresa_nm_contador', 200)->nullable();
            $table->string('empresa_cc_revisor', 15)->nullable();
            $table->string('empresa_tj_revisor', 15)->nullable();
            $table->string('empresa_nm_revisor', 200)->nullable();
            $table->string('empresa_fecha_cierre_contabilidad')->nullable();

            $table->foreign('empresa_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_empresa');
    }
}
