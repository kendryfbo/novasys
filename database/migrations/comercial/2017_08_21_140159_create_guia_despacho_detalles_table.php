<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuiaDespachoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_despacho_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guia_id')->unsigned(); // FK
            $table->integer('item');
            $table->integer('producto_id')->unsigned(); // FK
            $table->string('descripcion');
            $table->string('cantidad');
            $table->timestamps();

        });

        Schema::table('guia_despacho_detalles', function (Blueprint $table) {
            $table->foreign('guia_id')->references('id')->on('guia_despachos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guia_despacho_detalles');
    }
}
