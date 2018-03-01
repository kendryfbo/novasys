<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_detalles', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('proforma_id')->unsigned(); //FK
            $table->integer('item')->unsigned();
            $table->integer('producto_id')->unsigned(); //FK
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->double('precio',10,2);
            $table->double('descuento',10,2);
            $table->double('sub_total',10,2);
            $table->double('peso_neto',10,2);
            $table->double('peso_bruto',10,2);
            $table->double('volumen',10,2);
            $table->timestamps();
        });

        Schema::table('proforma_detalles', function (Blueprint $table) {
            $table->foreign('proforma_id')->references('id')->on('proformas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('proforma_detalles');
    }
}
