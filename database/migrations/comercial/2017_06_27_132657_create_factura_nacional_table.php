<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_nacional', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('cv_id')->unsigned();
            $table->string('cv_rut');
            $table->string('centro_venta');
            $table->integer('cliente_id')->unsigned();
            $table->string('cliente_rut');
            $table->string('cliente');
            $table->string('despacho');
            $table->string('cond_pago');
            $table->string('observacion')->nullable();
            $table->integer('vendedor_id')->unsigned();
            $table->string('vendedor');
            $table->decimal('sub_total',10,2);
            $table->decimal('descuento',10,2);
            $table->decimal('neto',10,2);
            $table->decimal('iva',10,2);
            $table->decimal('iaba',10,2);
            $table->decimal('total',10,2);
            $table->decimal('peso_neto',10,2);
            $table->decimal('peso_bruto',10,2);
            $table->decimal('volumen',10,2);
            $table->decimal('pagado',10,2)->default(0.00);
            $table->tinyInteger('cancelada')->default(0);
            $table->integer('user_id')->unsigned();
            $table->date('fecha_emision');
            $table->date('fecha_venc');
            $table->timestamps();
        });

        // Schema::table('factura_nacional', function (Blueprint $table) {
        //     $table->foreign('cv_id')->references('id')->on('centro_ventas');
        //     $table->foreign('cliente_id')->references('id')->on('cliente_nacional');
        //     $table->foreign('vendedor_id')->references('id')->on('vendedores');
        //     $table->foreign('user_id')->references('id')->on('usuarios');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_nacional');
    }
}
