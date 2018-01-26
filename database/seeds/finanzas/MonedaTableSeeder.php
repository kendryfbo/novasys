<?php

use Illuminate\Database\Seeder;
use App\Models\Finanzas\Moneda;

class MonedaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monedas = [
            ['id' => 1, 'descripcion' => 'Pesos Chilenos', 'simbolo' => '$', 'pais' => 'Chile', 'activo' => 1],
            ['id' => 1, 'descripcion' => 'Dolares Americanos', 'simbolo' => '$$', 'pais' => 'Estados Unidos', 'activo' => 1],
        ];

        foreach ($monedas as $moneda) {

            Moneda::create($moneda);
        }
    }
}
