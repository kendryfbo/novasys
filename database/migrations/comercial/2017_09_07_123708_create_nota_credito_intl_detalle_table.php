<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaCreditoIntlDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_intl_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nc_id')->unsigned();
            $table->integer('prod_id')->unsigned();
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('descuento');
            $table->integer('sub_total');
            $table->timestamps();
        });

        Schema::table('nota_credito_intl_detalle', function (Blueprint $table) {
            $table->foreign('nc_id')->references('id')->on('nota_credito_intl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_credito_intl_detalle');
    }
}
