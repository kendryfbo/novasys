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
            $table->string('insumo_cod');
            $table->string('insumo_descrip');
            $table->integer('nivel_id');
            $table->double('cantxuni');
            $table->double('cantxcaja');
            $table->double('cantxbatch');
            $table->double('batch');
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
        Schema::dropIfExists('formula_detalles');
    }
}
