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
            ['descripcion' => 'Cheque al Dia', 'dias' => 1, 'activo' => 1],
            ['descripcion' => 'Cheque a 7 Dias', 'dias' => 7, 'activo' => 1],
            ['descripcion' => 'Cheque a 15 Dias', 'dias' => 15, 'activo' => 1],
            ['descripcion' => 'Cheque a 30 Dias', 'dias' => 30, 'activo' => 1],
            ['descripcion' => 'Cheque a 45 Dias', 'dias' => 45, 'activo' => 1],
            ['descripcion' => 'Cheque a 60 Dias', 'dias' => 60, 'activo' => 1],
            ['descripcion' => 'Cheque a 90 Dias', 'dias' => 90, 'activo' => 1],
            ['descripcion' => 'Credito a 10 Dias', 'dias' => 10, 'activo' => 1],
            ['descripcion' => 'Credito a 30 Dias', 'dias' => 30, 'activo' => 1],
            ['descripcion' => 'Credito a 45 Dias', 'dias' => 45, 'activo' => 1],
            ['descripcion' => 'Credito a 60 Dias', 'dias' => 60, 'activo' => 1],
            ['descripcion' => 'Credito a 90 Dias', 'dias' => 90, 'activo' => 1],
            ['descripcion' => 'Efectivo', 'dias' => 1, 'activo' => 1]
        ];

        foreach ($formasPagos as $formas) {

            FormaPagoNac::create($formas);
        }
    }
}
