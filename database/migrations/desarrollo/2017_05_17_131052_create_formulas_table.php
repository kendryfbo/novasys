<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id')->unique();
            $table->tinyInteger('generada')->default(0);
            $table->string('generada_por')->nullable();
            $table->date('fecha_gen')->nullable(); // fecha de generacion
            $table->tinyInteger('autorizado')->nullable();
            $table->string('autorizada_por')->nullable();
            $table->date('fecha_aut')->nullable(); //fecha de autorizacion
            $table->double('cant_batch');
            $table->timestamps();
        });

        Schema::table('formulas', function (Blueprint $table) {
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulas');
    }
}
