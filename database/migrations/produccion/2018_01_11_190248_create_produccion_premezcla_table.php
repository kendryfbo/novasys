<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduccionPremezclaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion_premezcla', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned();
            $table->integer('premezcla_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->double('cant_batch');
            $table->date('fecha');
            $table->integer('status_id')->unsigned();
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
        Schema::dropIfExists('produccion_premezcla');
    }
}
