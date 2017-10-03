<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaNacionalDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fact_nac_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fact_id')->unsigned();
            $table->integer('item')->unsigned();
            $table->integer('producto_id');
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->decimal('descuento',10,2);
            $table->decimal('sub_total',10,2);
            $table->timestamps();
        });

        Schema::table('fact_nac_detalles', function (Blueprint $table) {
            $table->foreign('fact_id')->references('id')->on('factura_nacional')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fact_nac_detalles');
    }
}
