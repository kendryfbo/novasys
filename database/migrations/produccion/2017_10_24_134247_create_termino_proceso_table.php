<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminoProcesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termino_proceso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prod_id')->unsigned();
            $table->string('turno');
            $table->integer('producidas');
            $table->integer('rechazadas');
            $table->date('fecha_prod');
            $table->date('fecha_venc');
            $table->string('maquina');
            $table->string('operador');
            $table->string('cod')->nullable();
            $table->string('batch');
            $table->STRING('lote')->unique();
            $table->tinyInteger('almacenado')->default(0);
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
        Schema::dropIfExists('termino_proceso');
    }
}
