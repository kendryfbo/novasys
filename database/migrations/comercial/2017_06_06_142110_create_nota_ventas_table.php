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
            $table->string('orden_compra')->nullable();
            $table->string('despacho');
            $table->string('cond_pago');
            $table->integer('version');
            $table->integer('vendedor_id')->unsigned();
            $table->integer('sub_total');
            $table->integer('descuento');
            $table->integer('neto');
            $table->integer('iva');
            $table->integer('iaba');
            $table->integer('total');
            $table->decimal('peso_neto',10,2);
            $table->decimal('peso_bruto',10,2);
            $table->decimal('volumen',10,2);
            $table->integer('user_id')->unsigned();
            $table->date('fecha_emision');
            $table->date('fecha_despacho');
            $table->tinyInteger('aut_comer')->nullable();
            $table->tinyInteger('aut_contab')->nullable();
            $table->TinyInteger('status')->default(1);
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
