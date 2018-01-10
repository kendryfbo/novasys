<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('oc_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('codigo');
            $table->string('descripcion');
            $table->string('unidad');
            $table->integer('cantidad');
            $table->double('precio',10,2);
            $table->double('sub_total');
            $table->integer('recibidas');

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
        Schema::dropIfExists('orden_compra_detalles');
    }
}
