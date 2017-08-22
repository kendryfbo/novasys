<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuiaDespachosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_despachos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('proforma_id')->unsigned()->unique();
            $table->integer('aduana_id')->unsigned()->unique();
            $table->string('mn');
            $table->string('booking');
            $table->string('contenedor');
            $table->string('sello');
            $table->string('chofer');
            $table->string('patente');
            $table->string('movil');
            $table->string('prof');
            $table->string('dus');
            $table->double('peso_neto',10,2);
            $table->double('peso_bruto',10,2);
            $table->double('volumen',10,2);
            $table->date('fecha_emision');
            $table->string('nota')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('guia_despachos', function (Blueprint $table) {
            $table->foreign('proforma_id')->references('id')->on('proformas');
            $table->foreign('aduana_id')->references('id')->on('aduanas');
            $table->foreign('user_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guia_despachos');
    }
}
