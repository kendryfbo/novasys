<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduccionEnvasadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion_envasado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned();
            $table->integer('formula_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->double('cant_batch');
            $table->date('fecha_prod');
            $table->date('fecha_venc');
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('produccion_envasado', function (Blueprint $table) {
            $table->foreign('formula_id')->references('id')->on('formulas')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('usuarios')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status_documento')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produccion_envasado');
    }
}
