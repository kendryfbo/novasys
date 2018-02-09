<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->string('descripcion');
            $table->integer('tipo_id');
            $table->integer('item_id')->nullable();
            $table->date('fecha_ing');
            $table->tinyInteger('por_procesar');
            $table->integer('status_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('ingreso', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_documento')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('usuarios')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso');
    }
}
