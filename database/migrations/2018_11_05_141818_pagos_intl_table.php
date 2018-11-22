<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagosIntlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_intl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->string('numero_documento');             //documento SWIFT bancario
            $table->string('monto')->nullable();
            $table->date('fecha_pago');
            $table->timestamps();
        });

        Schema::table('pagos_intl', function (Blueprint $table) {
            $table->foreign('factura_id')->references('id')->on('factura_intl');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_intl');
    }
}
