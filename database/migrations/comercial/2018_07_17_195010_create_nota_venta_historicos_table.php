<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaVentaHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_venta_historicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nv_id')->unsigned(); //FK
            $table->integer('numero')->unique();
            $table->integer('cv_id')->unsigned();
            $table->string('centro_venta');
            $table->integer('cliente_id')->unsigned();
            $table->string('cliente');
            $table->string('orden_compra')->nullable();
            $table->string('direccion');
            $table->string('despacho');
            $table->string('cond_pago');
            $table->integer('version');
            $table->integer('vendedor_id')->unsigned();
            $table->integer('vendedor')->unsigned();
            $table->integer('sub_total');
            $table->integer('descuento');
            $table->integer('neto');
            $table->integer('iva');
            $table->integer('iaba');
            $table->integer('total');
            $table->decimal('peso_neto',10,2);
            $table->decimal('peso_bruto',10,2);
            $table->decimal('volumen',10,2);
            $table->date('fecha_emision');
            $table->date('fecha_despacho');
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
        Schema::dropIfExists('nota_venta_historicos');
    }
}
