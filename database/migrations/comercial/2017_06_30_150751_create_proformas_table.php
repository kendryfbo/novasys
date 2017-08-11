<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('version');
            $table->integer('cv_id')->unsigned(); // FK
            $table->string('centro_venta');
            $table->integer('cliente_id')->unsigned(); // FK
            $table->string('cliente');
            $table->date('fecha_emision');
            $table->date('semana');
            $table->string('direccion');
            $table->string('nota');
            $table->string('transporte');
            $table->string('puerto_emb');
            $table->string('puerto_dest');
            $table->string('forma_pago');
            $table->string('moneda');
            $table->string('clau_venta');
            $table->double('peso_neto',10,2)->nullable();
            $table->double('peso_bruto',10,2)->nullable();
            $table->double('volumen',10,2)->nullable();
            $table->double('total_fob',10,2);
            $table->double('total_freight',10,2);
            $table->double('total_insurance',10,2);
            $table->double('total_cif',10,2);
            $table->double('porc_desc',10,2);
            $table->double('total_desc',10,2);
            $table->double('total',10,2);
            $table->timestamps();
        });

        Schema::table('proformas', function (Blueprint $table) {
            $table->foreign('cv_id')->references('id')->on('centro_ventas');
            $table->foreign('cliente_id')->references('id')->on('cliente_intl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proformas');
    }
}
