<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('cv_id')->unsigned();
            $table->integer('prov_id')->unsigned();
            $table->integer('area_id')->unsigned(); // determinar areas
            $table->integer('usuario_id')->unsigned(); // Guarda ID de quien crea OC
            $table->string('contacto'); // persona de contacto
            $table->string('forma_pago'); // forma pago adquisiciones
            $table->string('nota')->nullable();
            $table->date('fecha_emision');
            $table->string('moneda');
            $table->double('sub_total',10,2);
            $table->double('descuento',10,2);
            $table->double('neto',10,2);
            $table->double('impuesto',10,2);
            $table->double('total',10,2);
            $table->tinyInteger('aut_contab')->nullable();
            $table->integer('aut_contab_uid')->nullable(); //Guarda ID de quien autoriza OC.
            $table->integer('status_id')->unsigned(); //  status de orden de compra Ej: completada,pendiente
            $table->integer('tipo_id')->unsigned(); // tipo de Orden de compra Ej: Factura, Honorarios, Boleta
            $table->timestamps();
        });

        Schema::table('orden_compra', function (Blueprint $table) {
            $table->foreign('cv_id')->references('id')->on('centro_ventas');
            $table->foreign('prov_id')->references('id')->on('proveedores');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('status_id')->references('id')->on('status_documento');
            $table->foreign('tipo_id')->references('id')->on('orden_compra_tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra');
    }
}
