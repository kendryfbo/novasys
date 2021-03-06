<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ing_id')->unsigned();
            $table->integer('tipo_id');
            $table->integer('item_id');
            $table->date('fecha_ing');
            $table->date('fecha_venc')->nullable();
            $table->string('lote')->nullable();
            $table->double('cantidad',10,2);
            $table->double('por_procesar',10,2);
            $table->timestamps();
        });

        Schema::table('ingreso_detalle', function (Blueprint $table) {
            $table->foreign('ing_id')->references('id')->on('ingreso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_detalle');
    }
}
