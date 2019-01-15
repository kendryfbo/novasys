<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnvioMailDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_mail_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('envmail_id')->unsigned();
            $table->string('descripcion');
            $table->string('mail');
            $table->tinyInteger('activo');
            $table->timestamps();
        });

        Schema::table('envio_mail_detalles', function (Blueprint $table) {
            $table->foreign('envmail_id')->references('id')->on('envio_mail')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envio_mail_detalle');
    }
}
