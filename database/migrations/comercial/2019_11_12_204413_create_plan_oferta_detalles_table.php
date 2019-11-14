<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanOfertaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_oferta_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->integer('cliente_id');
            $table->integer('producto_id');
            $table->string('nombre_cliente');
            $table->string('nombre_producto');
            $table->integer('descuento');
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
        Schema::dropIfExists('plan_oferta_detalles');
    }
}
