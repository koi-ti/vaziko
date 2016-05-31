<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_documento', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('documento_codigo', 20)->unique();
            $table->string('documento_nombre', 200);
            $table->integer('documento_consecutivo')->default(0);
            $table->string('documento_tipo_consecutivo', 1)->comment = 'M - Manual, A - Automatico';
            $table->integer('documento_folder')->unsigned()->nullable();

            $table->foreign('documento_folder')->references('id')->on('koi_folder')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_documento');
    }
}
