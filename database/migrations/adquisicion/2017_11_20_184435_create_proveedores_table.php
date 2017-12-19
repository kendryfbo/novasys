<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut')->unique();
            $table->string('descripcion');
            $table->string('abreviacion');
            $table->string('direccion');
            $table->string('region');
            $table->string('provincia');
            $table->string('comuna');
            $table->string('ciudad');
            $table->string('fono');
            $table->string('fax');
            $table->string('giro');
            $table->string('contacto');
            $table->string('cargo');
            $table->string('celular');
            $table->string('email');
            $table->string('cond_pago');
            $table->string('cto_cbrnza');
            $table->string('email_cbrnza');
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
        Schema::dropIfExists('proveedores');
    }
}
