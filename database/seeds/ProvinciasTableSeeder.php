<?php

use Illuminate\Database\Seeder;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provincias = [
            // Provincias de Region Metropolitana
            ['id' => 49, 'descripcion' => 'Santiago', 'region_id' => 15],
            ['id' => 50, 'descripcion' => '', 'region_id' => 15],
            ['id' => 51, 'descripcion' => '', 'region_id' => 15],
            ['id' => 52, 'descripcion' => '', 'region_id' => 15],
            ['id' => 53, 'descripcion' => '', 'region_id' => 15],
            ['id' => 54, 'descripcion' => '', 'region_id' => 15],
        ]
    }
}
