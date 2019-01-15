<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->string('descripcion');
            $table->integer('tipo_id')->unsigned();
            $table->integer('item_id')->nullable();
            $table->integer('item_num')->nullable();
            $table->date('fecha_egr');
            $table->integer('status_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('egreso', function (Blueprint $table) {
            $table->foreign('tipo_id')->references('id')->on('egreso_tipo')->onUpdate('cascade');
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
        Schema::dropIfExists('egreso');
    }
}
