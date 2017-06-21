<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('cv_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->string('despacho');
            $table->string('cond_pago');
            $table->integer('version');
            $table->integer('vendedor_id')->unsigned();
            $table->tinyInteger('aut_comer')->nullable();
            $table->tinyInteger('aut_contab')->nullable();
            $table->decimal('sub_total',10,2);
            $table->decimal('descuento',10,2);
            $table->decimal('neto',10,2);
            $table->decimal('iva',10,2);
            $table->decimal('iaba',10,2);
            $table->decimal('total',10,2);
            $table->decimal('peso_neto',10,2);
            $table->decimal('peso_bruto',10,2);
            $table->decimal('volumen',10,2);
            $table->integer('user_id')->unsigned();
            $table->date('fecha_emision');
            $table->date('fecha_venc');
            $table->integer('factura')->nullable();
            $table->timestamps();
        });

        Schema::table('nota_ventas', function (Blueprint $table) {
            $table->foreign('cv_id')->references('id')->on('centro_ventas');
            $table->foreign('cliente_id')->references('id')->on('cliente_nacional');
            $table->foreign('vendedor_id')->references('id')->on('vendedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_ventas');
    }
}
