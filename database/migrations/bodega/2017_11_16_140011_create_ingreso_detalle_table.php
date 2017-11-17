<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ing_id');
            $table->integer('tipo_id');
            $table->integer('item_id');
            $table->date('fecha_venc');
            $table->integer('cantidad');
            $table->integer('ingresado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_detalle');
    }
}
