<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalletDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pallet_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('ing_tipo_id')->unsigned();
            $table->integer('ing_id')->unsigned()->nullable();
            $table->integer('cantidad');
            $table->date('fecha_venc');
            $table->timestamps();
        });

        Schema::table('pallet_detalle', function (Blueprint $table) {
            $table->foreign('pallet_id')->references('id')->on('pallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pallet_detalle');
    }
}
