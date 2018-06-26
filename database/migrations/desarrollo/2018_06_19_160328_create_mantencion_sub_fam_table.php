<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantencionSubFamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantencion_sub_fam', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',50)->unique();
            $table->string('descripcion');
            $table->integer('familia_id')->unsigned();
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('mantencion_sub_fam', function (Blueprint $table) {
            $table->foreign('familia_id')->references('id')->on('familias')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantencion_sub_fam');
    }
}
