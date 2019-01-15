<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdMezDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_mez_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prodmez_id')->unsigned();
            $table->integer('insumo_id')->unsigned();
            $table->double('cantidad');
            $table->timestamps();
        });

        Schema::table('prod_mez_detalle', function (Blueprint $table) {
            $table->foreign('prodmez_id')->references('id')->on('produccion_mezclado')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_mez_detalle');
    }
}
