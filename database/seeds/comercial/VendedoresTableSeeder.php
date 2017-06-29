<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Vendedor;

class VendedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendedores = [
            ['rut' => '1', 'nombre' => 'Victor Jara', 'iniciales' => 'VJ', 'activo' =>1],
            ['rut' => '2', 'nombre' => 'Rodrigo Vargas', 'iniciales' => 'RV', 'activo' =>1],
            ['rut' => '3', 'nombre' => 'Patricio Rojas', 'iniciales' => 'PR', 'activo' =>1],
            ['rut' => '4', 'nombre' => 'Luis Martinez','iniciales' => 'LM',  'activo' =>1],
        ];

        foreach ($vendedores as $vendedor) {

            Vendedor::create($vendedor);
        }
    }
}
