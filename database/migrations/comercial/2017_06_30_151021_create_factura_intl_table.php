<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaIntlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_intl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('proforma')->unsigned()->unique()->nullable();
            $table->integer('cv_id')->unsigned(); // FK
            $table->string('centro_venta');
            $table->integer('cliente_id')->unsigned(); // FK
            $table->string('cliente');
            $table->date('fecha_emision');
            $table->date('fecha_venc');
            $table->string('direccion');
            $table->string('nota');
            $table->string('transporte');
            $table->string('puerto_emb');
            $table->string('puerto_dest');
            $table->string('forma_pago');
            $table->string('clau_venta');
            $table->double('fob',10,2);
            $table->double('freight',10,2);
            $table->double('insurance',10,2);
            $table->double('cif',10,2);
            $table->double('descuento',10,2);
            $table->double('total',10,2);
            $table->tinyInteger('cancelada')->default(0);
            $table->integer('user_id')->unsigned(); // FK usuarios
            $table->timestamps();
        });

        Schema::table('factura_intl', function (Blueprint $table) {
            $table->foreign('cv_id')->references('id')->on('centro_ventas');
            $table->foreign('cliente_id')->references('id')->on('cliente_intl');
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
        Schema::dropIfExists('factura_intl');
    }
}
