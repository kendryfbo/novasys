<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formula_id');
            $table->string('insumo_id');
            $table->string('descripcion');
            $table->integer('nivel_id');
            $table->double('cantxuni');
            $table->double('cantxcaja');
            $table->double('cantxbatch');
            $table->double('batch');
            $table->timestamps();
        });

        Schema::table('formula_detalles', function (Blueprint $table) {
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formula_detalles');
    }
}
