<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('unidad_med');
            $table->double('peso');
            $table->integer('sobre');
            $table->integer('display');
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        DB::update("ALTER TABLE formatos AUTO_INCREMENT = 101;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formatos');
    }
}
