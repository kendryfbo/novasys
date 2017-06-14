<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Canal;

class CanalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canales = [
            ['descripcion' => 'Supermercado', 'descuento' => 8.00, 'activo' => 1],
            ['descripcion' => 'Mayorista', 'descuento' => 13.52, 'activo' => 1],
            ['descripcion' => 'Distribuidores', 'descuento' => 16.98, 'activo' => 1]
        ];

        foreach ($canales as $canal) {

            Canal::create($canal);
        }
    }
}
