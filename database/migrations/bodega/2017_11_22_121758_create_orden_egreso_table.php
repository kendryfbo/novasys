<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenEgresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_egreso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unique();
            $table->integer('tipo_doc')->unsigned();
            $table->integer('doc_id')->unsigned();
            $table->date('fecha_gen');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('orden_egreso');
    }
}
