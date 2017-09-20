<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaDebitoNacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_debito_nac', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero');
            $table->integer('num_nc');
            $table->string('nota')->nullable();
            $table->integer('neto');
            $table->integer('iaba');
            $table->integer('iva');
            $table->integer('total');
            $table->date('fecha');
            $table->tinyInteger('aut_comer')->nullable();
            $table->tinyInteger('aut_contab')->nullable();
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
        Schema::dropIfExists('nota_debito_nac');
    }
}
