<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdPremDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_prem_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prodprem_id')->unsigned();
            $table->integer('insumo_id')->unsigned();
            $table->double('cantidad');
            $table->timestamps();
        });

        Schema::table('prod_prem_detalle', function (Blueprint $table) {
            $table->foreign('prodprem_id')->references('id')->on('produccion_premezcla')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('prod_prem_detalle');
    }
}
