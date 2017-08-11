<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAduanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aduanas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut');
            $table->string('descripcion');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('comuna');
            $table->string('fono');
            $table->string('tipo');
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
        Schema::dropIfExists('aduanas');
    }
}
