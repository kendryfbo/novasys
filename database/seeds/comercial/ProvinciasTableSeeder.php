<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Provincia;

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
            ['id' => 50, 'descripcion' => 'Cordillera', 'region_id' => 15],
            ['id' => 51, 'descripcion' => 'Chacabuco', 'region_id' => 15],
            ['id' => 52, 'descripcion' => 'Maipo', 'region_id' => 15],
            ['id' => 53, 'descripcion' => 'Melipilla', 'region_id' => 15],
            ['id' => 54, 'descripcion' => 'Talagante', 'region_id' => 15],
        ];

        foreach ($provincias as $provincia) {

            Provincia::create($provincia);
        }
    }
}
