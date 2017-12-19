<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('prov_id')->unsigned();
            $table->integer('area_id')->unsigned(); // determinar areas
            $table->string('contacto'); // persona de contacto
            $table->string('fp_id'); // forma pago adquisiciones
            $table->string('moneda');
            $table->double('sub_total',10,2);
            $table->double('descuento',10,2);
            $table->double('neto',10,2);
            $table->double('impuesto',10,2);
            $table->double('bruto',10,2); // honorarios
            $table->double('retencion',10,2); // honorarios
            $table->double('liquido',10,2); // honorarios
            $table->double('total',10,2);
            $table->date('emision');
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
        Schema::dropIfExists('orden_compra');
    }
}
