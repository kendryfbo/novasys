<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Impuesto;

class ImpuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $impuestos = [
            ['nombre' => 'iva', 'descripcion' => 'Impuesto Sobre el Valor Añadido', 'valor' => 19, 'activo' => 1],
            ['nombre' => 'iaba', 'descripcion' => 'Impuestos a las Bebidas Analcohólicas', 'valor' => 10, 'activo' => 1]
        ];

        foreach ($impuestos as $impuesto) {

            Impuesto::create($impuesto);
        }
    }
}
