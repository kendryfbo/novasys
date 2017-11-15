<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Region;

class RegionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regiones = [
            ['id' => 1, 'descripcion' => 'Arica y Parinacota'],
            ['id' => 2, 'descripcion' => 'Tarapacá'],
            ['id' => 3, 'descripcion' => 'Antofagasta'],
            ['id' => 4, 'descripcion' => 'Atacama'],
            ['id' => 5, 'descripcion' => 'Coquimbo'],
            ['id' => 6, 'descripcion' => 'Valparaíso'],
            ['id' => 7, 'descripcion' => 'Del Libertador Gral. Bernardo O`Higgins'],
            ['id' => 8, 'descripcion' => 'Del Maule'],
            ['id' => 9, 'descripcion' => 'Del Biobío'],
            ['id' => 10, 'descripcion' => 'De la Araucanía'],
            ['id' => 11, 'descripcion' => 'De los Ríos'],
            ['id' => 12, 'descripcion' => 'De los Lagos'],
            ['id' => 13, 'descripcion' => 'Aisén del Gral. Carlos Ibañez del Campo'],
            ['id' => 14, 'descripcion' => 'Magallanes y de la Antártica Chilena'],
            ['id' => 15, 'descripcion' => 'Metropolitana de Santiago']
        ];

        foreach ($regiones as $region) {

            Region::create($region);
        }
    }
}
