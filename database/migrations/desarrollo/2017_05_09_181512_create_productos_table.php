<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',50)->unique();
            $table->string('descripcion');
            $table->integer('marca_id')->unsigned();
            $table->integer('formato_id')->unsigned();
            $table->integer('sabor_id')->unsigned();
            $table->integer('vida_util');
            $table->double('peso_neto');
            $table->double('peso_bruto');
            $table->double('volumen');
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->foreign('marca_id')->references('id')->on('marcas')->onUpdate('cascade');
            $table->foreign('formato_id')->references('id')->on('formatos')->onUpdate('cascade');
            $table->foreign('sabor_id')->references('id')->on('sabores')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
