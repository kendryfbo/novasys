<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteIntlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_intl', function (Blueprint $table) {

            $table->increments('id');
            $table->string('descripcion');
            $table->string('direccion');
            $table->string('pais');
            $table->string('zona');
            $table->string('idioma');
            $table->string('fono');
            $table->string('giro');
            $table->string('fax');
            $table->string('contacto');
            $table->string('cargo');
            $table->string('email');
            $table->integer('fp_id')->unsigned();
            $table->decimal('credito',10,2);
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('cliente_intl', function (Blueprint $table) {

            $table->foreign('fp_id')->references('id')->on('forma_pago_intl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_intl');
    }
}
