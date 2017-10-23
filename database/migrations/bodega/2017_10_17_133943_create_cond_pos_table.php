<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCondPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cond_pos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('posicion_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('opcion_id')->unsigned();
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('cond_pos', function (Blueprint $table) {
            $table->foreign('posicion_id')->references('id')->on('posicion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tipo_id')->references('id')->on('cond_pos_tipo')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cond_pos');
    }
}
