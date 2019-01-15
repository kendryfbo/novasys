<?php

use Illuminate\Database\Seeder;
use App\Models\Adquisicion\Area;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            ['id' => 1,  'descripcion' => 'Calidad', 'activo' => 1],
            ['id' => 2,  'descripcion' => 'Mantencion', 'activo' => 1],
            ['id' => 3,  'descripcion' => 'Administracio', 'activo' => 1],
            ['id' => 4,  'descripcion' => 'Soporte', 'activo' => 1],
            ['id' => 5,  'descripcion' => 'Bodega', 'activo' => 1],
            ['id' => 6,  'descripcion' => 'Diseño', 'activo' => 1],
            ['id' => 7,  'descripcion' => 'Produccion', 'activo' => 1],
            ['id' => 8,  'descripcion' => 'Serv. Generales', 'activo' => 1],
            ['id' => 9,  'descripcion' => 'Desarrollo', 'activo' => 1],
            ['id' => 10, 'descripcion' => 'Comercial', 'activo' => 1],
        ];

        foreach ($areas as $area) {

            Area::create($area);
        }
    }
}
