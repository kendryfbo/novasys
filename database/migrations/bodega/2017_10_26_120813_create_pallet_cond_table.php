<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalletCondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet_cond', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pallet_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->string('tipo');
            $table->integer('opcion_id')->unsigned();
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
        Schema::dropIfExists('pallet_cond');
    }
}
