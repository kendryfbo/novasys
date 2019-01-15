<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_historico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proforma_id')->unsigned(); //FK
            $table->integer('numero');
            $table->integer('version');
            $table->integer('cv_id')->unsigned(); // FK
            $table->string('centro_venta');
            $table->integer('cliente_id')->unsigned(); // FK
            $table->string('cliente');
            $table->date('fecha_emision');
            $table->integer('semana');
            $table->string('direccion');
            $table->string('despacho');
            $table->string('nota')->nullable();
            $table->string('transporte');
            $table->string('puerto_emb');
            $table->string('puerto_dest');
            $table->string('forma_pago');
            $table->string('clau_venta');
            $table->double('peso_neto',10,2)->nullable();
            $table->double('peso_bruto',10,2)->nullable();
            $table->double('volumen',10,2)->nullable();
            $table->double('fob',10,2);
            $table->double('freight',10,2);
            $table->double('insurance',10,2);
            $table->double('cif',10,2);
            $table->double('descuento',10,2);
            $table->double('total',10,2);
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
        Schema::dropIfExists('proforma_historico');
    }
}
