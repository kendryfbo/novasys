<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_nacional', function (Blueprint $table) {

            $table->increments('id');
            $table->string('rut');
            $table->string('descripcion');
            $table->string('direccion');
            $table->string('fono');
            $table->string('giro');
            $table->string('fax');
            $table->integer('rut_num');
            $table->string('contacto');
            $table->string('cargo');
            $table->string('email');
            $table->integer('region_id')->unsigned();
            $table->integer('provincia_id')->unsigned();
            $table->integer('comuna_id')->unsigned();
            $table->integer('vendedor_id')->unsigned();
            $table->tinyInteger('activo');
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
        Schema::dropIfExists('cliente_nacional');
    }
}
