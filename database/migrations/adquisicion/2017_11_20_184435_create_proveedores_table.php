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
            $table->string('abreviacion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('comuna')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('fono')->nullable();
            $table->string('fax')->nullable();
            $table->string('giro')->nullable();
            $table->string('contacto')->nullable();
            $table->string('cargo')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
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
