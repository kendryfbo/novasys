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
            ['rut' => '2', 'nombre' => 'Claudia Pinto', 'iniciales' => 'CP', 'activo' =>1],
            ['rut' => '3', 'nombre' => 'Jorge Herrera', 'iniciales' => 'JH', 'activo' =>1],
            ['rut' => '4', 'nombre' => 'Eduardo Bahamondes','iniciales' => 'EB',  'activo' =>1],
            ['rut' => '5', 'nombre' => 'Manuel Rodriguez','iniciales' => 'MR',  'activo' =>1],
            ['rut' => '6', 'nombre' => 'Gerencia','iniciales' => 'GCIA',  'activo' =>1],
        ];

        foreach ($vendedores as $vendedor) {

            Vendedor::create($vendedor);
        }
    }
}
