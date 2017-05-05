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
            ['descripcion' => 'Unidad','unidad' => 'uni'],
            ['descripcion' => 'Caja','unidad' => 'caj'],
            ['descripcion' => 'Gramo','unidad' => 'g'],
            ['descripcion' => 'Kilogramo','unidad' => 'kg'],
            ['descripcion' => 'Centimetro','unidad' => 'cm'],
            ['descripcion' => 'Metro','unidad' => 'mts'],
        ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        };

    }
}
