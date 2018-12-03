<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AbonosNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos_nacional', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('orden_despacho');
            $table->string('docu_abono');
            $table->double('monto',10,2)->nullable();
            $table->double('restante',10,2)->nullable();
            $table->date('fecha_abono');
            $table->timestamps();
        });

        Schema::table('abonos_nacional', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('cliente_nacional');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('status_id')->references('id')->on('status_documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonos_nacional');
    }
}
