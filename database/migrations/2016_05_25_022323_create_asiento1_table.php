<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsiento1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_asiento1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('asiento1_ano');
            $table->integer('asiento1_mes');
            $table->integer('asiento1_folder')->unsigned();
            $table->integer('asiento1_documento')->unsigned();
            $table->string('asiento1_documentos', 4)->nullable();
            $table->integer('asiento1_id_documentos')->unsigned()->nullable();
            $table->integer('asiento1_numero');
            $table->integer('asiento1_dia');
            $table->integer('asiento1_sucursal')->unsigned()->nullable();
            $table->integer('asiento1_beneficiario')->unsigned();
            $table->boolean('asiento1_preguardado')->default(false);
            $table->text('asiento1_detalle')->nullable();
            $table->integer('asiento1_usuario_elaboro')->unsigned();
            $table->datetime('asiento1_fecha_elaboro');

            $table->foreign('asiento1_folder')->references('id')->on('koi_folder')->onDelete('restrict');
            $table->foreign('asiento1_documento')->references('id')->on('koi_documento')->onDelete('restrict');
            $table->foreign('asiento1_beneficiario')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('asiento1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');

            $table->unique(['asiento1_mes', 'asiento1_ano', 'asiento1_folder', 'asiento1_documento', 'asiento1_numero'], 'koi_asiento1_mes_ano_folder_documento_numero_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_asiento1');
    }
}
