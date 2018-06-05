<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremezclasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premezclas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->unique();
            $table->string('descripcion')->unique();
            $table->string('unimed_id')->unsigned();
            $table->integer('familia_id')->unsigned();
            $table->integer('marca_id')->unsigned();
            $table->integer('sabor_id')->unsigned();
            $table->integer('formato_id')->unsigned();
            $table->integer('formato_id')->unsigned();
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('premezclas', function (Blueprint $table) {
            $table->foreign('familia_id')->references('id')->on('familias')->onUpdate('cascade');
            $table->foreign('marca_id')->references('id')->on('marcas')->onUpdate('cascade');
            $table->foreign('sabor_id')->references('id')->on('sabores')->onUpdate('cascade');
            $table->foreign('formato_id')->references('id')->on('formatos')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premezclas');
    }
}
