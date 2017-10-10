<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaCreditoIntlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_intl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero');
            $table->integer('num_fact');
            $table->string('nota')->nullable();
            $table->double('neto',10,2);
            $table->double('total',10,2);
            $table->date('fecha');
            $table->integer('user_id');
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
        Schema::dropIfExists('nota_credito_intl');
    }
}
