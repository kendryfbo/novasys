<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaVentaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_venta_detalles', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('nv_id')->unsigned(); //FK
            $table->integer('item')->unsigned();
            $table->integer('producto_id')->unsigned(); //FK
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->decimal('descuento',10,2);
            $table->decimal('sub_total',10,2);
            $table->timestamps();

        });

        Schema::table('nota_venta_detalles', function (Blueprint $table) {
            $table->foreign('nv_id')->references('id')->on('nota_ventas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_venta_detalles');
    }
}
