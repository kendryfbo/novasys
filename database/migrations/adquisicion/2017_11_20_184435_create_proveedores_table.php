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
            $table->string('comuna');
            $table->string('ciudad');
            $table->string('fono');
            $table->string('fax')->nullable();
            $table->string('giro');
            $table->string('contacto');
            $table->string('cargo');
            $table->string('celular');
            $table->string('email');
            $table->integer('fp_id')->unsigned();
            $table->string('cto_cbrnza')->nullable();
            $table->string('email_cbrnza')->nullable();
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('proveedores', function (Blueprint $table) {

            $table->foreign('fp_id')->references('id')->on('forma_pago_proveedor');
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
