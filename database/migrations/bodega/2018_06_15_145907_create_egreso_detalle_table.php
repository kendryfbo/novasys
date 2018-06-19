<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('egr_id')->unsigned();
            $table->integer('tipo_id');
            $table->integer('item_id');
            $table->string('bodega');
            $table->string('posicion');
            $table->date('fecha_egr');
            $table->date('fecha_venc')->nullable();
            $table->string('lote')->nullable();
            $table->double('cantidad',10,2);
            $table->timestamps();
        });

        Schema::table('egreso_detalle', function (Blueprint $table) {
            $table->foreign('egr_id')->references('id')->on('egreso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egreso_detalle');
    }
}
