<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagosNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_nacional', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('abono_id')->unsigned();
            $table->double('monto',10,2)->nullable();
            $table->date('fecha_pago');
            $table->timestamps();
        });

        Schema::table('pagos_nacional', function (Blueprint $table) {
            $table->foreign('factura_id')->references('id')->on('factura_nacional');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('abono_id')->references('id')->on('abonos_nacional');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_nacional');
    }
}
