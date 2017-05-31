<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Comuna;

class ComunasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comunas = [
            ['descripcion' => 'Santiago', 'provincia_id' => 49],
            ['descripcion' => 'Cerrillos', 'provincia_id' => 49],
            ['descripcion' => 'Cerro Navia', 'provincia_id' => 49],
            ['descripcion' => 'Conchalí', 'provincia_id' => 49],
            ['descripcion' => 'El Bosque', 'provincia_id' => 49],
            ['descripcion' => 'Estación Central', 'provincia_id' => 49],
            ['descripcion' => 'Huechuraba', 'provincia_id' => 49],
            ['descripcion' => 'Independencia', 'provincia_id' => 49],
            ['descripcion' => 'La Cisterna', 'provincia_id' => 49],
            ['descripcion' => 'La Florida', 'provincia_id' => 49],
            ['descripcion' => 'La Granja', 'provincia_id' => 49],
            ['descripcion' => 'La Pintana', 'provincia_id' => 49],
            ['descripcion' => 'La Reina', 'provincia_id' => 49],
            ['descripcion' => 'Las Condes', 'provincia_id' => 49],
            ['descripcion' => 'Lo Barnechea', 'provincia_id' => 49],
            ['descripcion' => 'Lo Espejo', 'provincia_id' => 49],
            ['descripcion' => 'Lo Prado', 'provincia_id' => 49],
            ['descripcion' => 'Macul', 'provincia_id' => 49],
            ['descripcion' => 'Maipú', 'provincia_id' => 49],
            ['descripcion' => 'Ñuñoa', 'provincia_id' => 49],
            ['descripcion' => 'Pedro Aguirre Cerda', 'provincia_id' => 49],
            ['descripcion' => 'Peñalolén', 'provincia_id' => 49],
            ['descripcion' => 'Providencia', 'provincia_id' => 49],
            ['descripcion' => 'Pudahuel', 'provincia_id' => 49],
            ['descripcion' => 'Quilicura', 'provincia_id' => 49],
            ['descripcion' => 'Quinta Normal', 'provincia_id' => 49],
            ['descripcion' => 'Recoleta', 'provincia_id' => 49],
            ['descripcion' => 'Renca', 'provincia_id' => 49],
            ['descripcion' => 'San Joaquín', 'provincia_id' => 49],
            ['descripcion' => 'San Miguel', 'provincia_id' => 49],
            ['descripcion' => 'San Ramón', 'provincia_id' => 49],
            ['descripcion' => 'Vitacura]', 'provincia_id' => 49]
        ];

        foreach ($comunas as $comuna) {

            Comuna::create($comuna);
        }
    }
}
