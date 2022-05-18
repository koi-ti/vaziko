<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_usuario_rol', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('koi_tercero')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('koi_rol')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_usuario_rol');
    }
}
