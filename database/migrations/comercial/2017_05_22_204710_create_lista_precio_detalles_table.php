<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaPrecioDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_precio_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lista_id');
            $table->integer('producto_id');
            $table->decimal('precio',10,2);
            $table->timestamps();
        });

        Schema::table('lista_precio_detalles', function (Blueprint $table) {
            $table->foreign('lista_id')->references('id')->on('lista_precios')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('lista_precio_detalles');
    }
}
