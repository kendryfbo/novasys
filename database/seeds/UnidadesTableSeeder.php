<?php

use Illuminate\Database\Seeder;
use App\Models\Unidad;
class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades =[
            ['descripcion' => 'Unidad', 'unidad' => 'uni', 'activo' => 1],
            ['descripcion' => 'Caja', 'unidad' => 'caj', 'activo' => 1],
            ['descripcion' => 'Gramo', 'unidad' => 'g', 'activo' => 1],
            ['descripcion' => 'Kilogramo', 'unidad' => 'kg', 'activo' => 1],
            ['descripcion' => 'Centimetro', 'unidad' => 'cm', 'activo' => 1],
            ['descripcion' => 'Metro', 'unidad' => 'mts', 'activo' => 1]
        ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        };

    }
}
