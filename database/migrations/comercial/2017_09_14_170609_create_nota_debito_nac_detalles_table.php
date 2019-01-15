<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaDebitoNacDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_debito_nac_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nd_id')->unsigned();
            $table->integer('prod_id')->unsigned();
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('descuento');
            $table->integer('sub_total');
            $table->timestamps();
        });

        Schema::table('nota_debito_nac_detalles', function (Blueprint $table) {
            $table->foreign('nd_id')->references('id')->on('nota_debito_nac')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_debito_nac_detalles');
    }
}
