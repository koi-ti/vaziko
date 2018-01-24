<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_materialp', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('materialp_nombre', 250);
            $table->text('materialp_descripcion')->nullable();
            $table->integer('materialp_tipomaterialp')->unsigned();

            $table->foreign('materialp_tipomaterialp')->references('id')->on('koi_tipomaterialp')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_materialp');
    }
}
