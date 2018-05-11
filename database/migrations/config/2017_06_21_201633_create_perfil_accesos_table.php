<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_accesos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('perfil_id')->unsigned();
            $table->string('acceso_id')->unsigned();
            $table->tinyInteger('acceso');
            $table->timestamps();
        });

        Schema::table('perfil_accesos', function (Blueprint $table) {
            $table->foreign('perfil_id')->references('id')->on('perfiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('acceso_id')->references('id')->on('accesos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_accesos');
    }
}
