<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posicion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bodega_id')->unsigned();
            $table->integer('bloque')->unsigned();
            $table->integer('columna')->unsigned();
            $table->integer('estante')->unsigned();
            $table->string('medida');
            $table->integer('status_id')->unsigned();
            $table->integer('pallet_id')->unsigned()->nullable()->unique();
            $table->index(['bloque', 'columna','estante']);
            $table->timestamps();
        });

        Schema::table('posicion', function (Blueprint $table) {
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pallet_id')->references('id')->on('pallets')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('posicion_status')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posicion');
    }
}
