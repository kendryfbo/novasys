<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo','10');
            $table->string('descripcion','100');
            $table->integer('familia_id')->unsigned();
            $table->tinyInteger('iaba');
            $table->tinyInteger('nacional');
            $table->tinyInteger('activo')->default('1');;
            $table->timestamps();
        });

        Schema::table('marcas', function (Blueprint $table) {
            $table->foreign('familia_id')->references('id')->on('familias');
        });

        DB::update("ALTER TABLE marcas AUTO_INCREMENT = 101;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcas');
    }
}
