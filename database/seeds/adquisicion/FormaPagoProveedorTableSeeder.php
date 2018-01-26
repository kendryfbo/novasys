<?php

use Illuminate\Database\Seeder;
use App\Models\Adquisicion\FormaPagoProveedor;

class FormaPagoProveedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formasPago = [
            ['id' => 1, 'descripcion' => 'Contado',                'dias' => 1,   'activo' => 1],
            ['id' => 2, 'descripcion' => '30 Días fecha factura',  'dias' => 30,  'activo' => 1],
            ['id' => 4, 'descripcion' => '60 Días fecha factura',  'dias' => 60,  'activo' => 1],
            ['id' => 5, 'descripcion' => '90 Días fecha factura',  'dias' => 90,  'activo' => 1],
            ['id' => 6, 'descripcion' => '120 Días fecha factura', 'dias' => 120, 'activo' => 1],
            ['id' => 7, 'descripcion' => 'Cheque',                 'dias' => 1,   'activo' => 1],
            ['id' => 8, 'descripcion' => 'Transferencia',          'dias' => 1,   'activo' => 1],
            ['id' => 8, 'descripcion' => '50% OC y 50% contra entrega', 'dias' => 1, 'activo' => 1],
        ];

        foreach ($formasPago as $formaPago) {

            FormaPagoProveedor::create($formaPago);
        };
    }
}
