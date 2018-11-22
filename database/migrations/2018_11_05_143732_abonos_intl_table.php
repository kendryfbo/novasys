<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AbonosIntlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos_intl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->string('orden_despacho');
            $table->string('monto')->nullable();
            $table->date('fecha_abono');
            $table->timestamps();
        });

        Schema::table('abonos_intl', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('cliente_intl');
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
        Schema::dropIfExists('abonos_intl');
    }
}
