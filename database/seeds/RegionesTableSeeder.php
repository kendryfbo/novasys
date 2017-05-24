<?php

use Illuminate\Database\Seeder;

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
            ['descripcion' => 'Arica y Parinacota'],
            ['descripcion' => 'Tarapacá'],
            ['descripcion' => 'Antofagasta'],
            ['descripcion' => 'Atacama'],
            ['descripcion' => 'Coquimbo'],
            ['descripcion' => 'Valparaíso'],
            ['descripcion' => 'Del Libertador Gral. Bernardo O`Higgins'],
            ['descripcion' => 'Del Maule'],
            ['descripcion' => 'Del Biobío'],
            ['descripcion' => 'De la Araucanía'],
            ['descripcion' => 'De los Ríos'],
            ['descripcion' => 'De los Lagos'],
            ['descripcion' => 'Aisén del Gral. Carlos Ibañez del Campo'],
            ['descripcion' => 'Magallanes y de la Antártica Chilena'],
            ['descripcion' => 'Metropolitana de Santiago']
        ]
    }
}
