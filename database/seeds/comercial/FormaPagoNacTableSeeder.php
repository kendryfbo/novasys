<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\FormaPagoNac;

class FormaPagoNacTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formasPagos = [
            ['descripcion' => 'Cheque al Dia', 'activo' => 1],
            ['descripcion' => 'Cheque a 7 Dias', 'activo' => 1],
            ['descripcion' => 'Cheque a 15 Dias', 'activo' => 1],
            ['descripcion' => 'Cheque a 30 Dias', 'activo' => 1],
            ['descripcion' => 'Cheque a 45 Dias', 'activo' => 1],
            ['descripcion' => 'Cheque a 60 Dias', 'activo' => 1],
            ['descripcion' => 'Cheque a 90 Dias', 'activo' => 1],
            ['descripcion' => 'Credito a 10 Dias', 'activo' => 1],
            ['descripcion' => 'Credito a 30 Dias', 'activo' => 1],
            ['descripcion' => 'Credito a 45 Dias', 'activo' => 1],
            ['descripcion' => 'Credito a 60 Dias', 'activo' => 1],
            ['descripcion' => 'Credito a 90 Dias', 'activo' => 1],
            ['descripcion' => 'Efectivo', 'activo' => 1]
        ];

        foreach ($formasPagos as $formas) {

            FormaPagoNac::create($formas);
        }
    }
}
