<?php
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdMantencionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_mantencion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',50)->unique();
            $table->string('descripcion');
            $table->integer('familia_id')->unsigned();
            $table->integer('mansubfam_id')->unsigned();
            $table->integer('unimed_id')->unsigned();
            $table->integer('stock_min');
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('prod_mantencion', function (Blueprint $table) {
            $table->foreign('familia_id')->references('id')->on('familias')->onUpdate('cascade');
            $table->foreign('mansubfam_id')->references('id')->on('mantencion_sub_fam')->onUpdate('cascade');
            $table->foreign('unimed_id')->references('id')->on('unidades')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_mantencion');
    }
}
