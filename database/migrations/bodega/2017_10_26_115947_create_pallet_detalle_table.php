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
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->date('fecha_venc');
            $table->string('lote')->nullable();
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
        Schema::dropIfExists('pallet_detalle');
    }
}
