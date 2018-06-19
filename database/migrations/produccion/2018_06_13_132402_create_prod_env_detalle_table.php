<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdEnvDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_env_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prodenv_id')->unsigned();
            $table->integer('insumo_id')->unsigned();
            $table->double('cantidad');
            $table->timestamps();
        });

        Schema::table('prod_env_detalle', function (Blueprint $table) {
            $table->foreign('prodenv_id')->references('id')->on('produccion_envasado')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('prod_env_detalle');
    }
}
