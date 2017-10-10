<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\CentroVenta;

class CentroVentaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $centroVentas = [
            ['rut' => '96873090-8',
            'descripcion' => 'NOVAFOODS S.A.',
            'giro' => 'Elaboración, Comercialización Alimentos Procesados en Polvo, Importación y Exportación',
            'direccion' => 'Quilin 4000, Macul.',
            'fono' => '+56 2 2294 7252',
            'activo' => 1],

            ['rut' => '99564310-3',
            'descripcion' => 'ALIMENTOS SUMARCA S A',
            'giro' => 'Prod. y Dist de Prod Alim Import Export Prod Publicitarios',
            'direccion' => 'Quilin 4000 Interior - Macul',
            'fono' => '+56 2 2294 7252',
            'activo' => 1],

            ['rut' => '76240899-6',
            'descripcion' => 'MERCADO NACIONAL S.A.',
            'giro' => 'Distribuidora y Comercializadora de Productos Alimenticions',
            'direccion' => 'Quilin 4000, Of. 2 -Macul',
            'fono' => '',
            'activo' => 1]
        ];

        foreach ($centroVentas as $centro) {

            CentroVenta::create($centro);
        }
    }
}
