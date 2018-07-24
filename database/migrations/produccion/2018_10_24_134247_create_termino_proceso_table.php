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
            $table->integer('prodenv_id')->unsigned();
            $table->string('turno');
            $table->integer('producidas');
            $table->integer('rechazadas');
            $table->integer('total');
            $table->date('fecha_prod');
            $table->date('fecha_venc');
            $table->string('maquina');
            $table->string('operador');
            $table->string('cod')->nullable();
            $table->string('batch');
            $table->string('lote');
            $table->integer('ingresadas')->default(0);
            $table->integer('status_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('termino_proceso', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_documento')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('usuarios')->onUpdate('cascade');
            $table->foreign('prodenv_id')->references('id')->on('produccion_envasado')->onUpdate('cascade');
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
