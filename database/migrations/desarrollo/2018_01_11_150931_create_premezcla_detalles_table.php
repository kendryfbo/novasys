<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremezclaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premezcla_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prem_id')->unsigned();
            $table->integer('prod_id')->unsigned()->unique();
            $table->timestamps();
        });

        Schema::table('premezcla_detalles', function (Blueprint $table) {
            $table->foreign('prem_id')->references('id')->on('premezclas')->onDelete('cascade');
            $table->foreign('prod_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premezcla_detalles');
    }
}
