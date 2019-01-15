<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenEgresoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_egreso_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('bodega');
            $table->string('posicion');
            $table->integer('cantidad')->unsigned();
            $table->timestamps();
        });

        Schema::table('orden_egreso_detalles', function (Blueprint $table) {

            $table->foreign('orden_id')->references('id')->on('orden_egreso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_egreso_detalles');
    }
}
