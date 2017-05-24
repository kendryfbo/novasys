<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo','10');
            $table->string('descripcion','100');
            $table->integer('tipo_id')->unsigned();
            $table->tinyInteger('activo')->default('1');
            $table->timestamps();
        });

        Schema::table('familias', function (Blueprint $table) {
            $table->foreign('tipo_id')->references('id')->on('tipo_familias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familias');
    }
}
