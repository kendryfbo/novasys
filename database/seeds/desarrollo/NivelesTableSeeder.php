<?php

use Illuminate\Database\Seeder;
use App\Models\Nivel;
class NivelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $niveles = [
            ['id' => 1, 'descripcion' => 'Base', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Premix', 'activo' => 1],
            ['id' => 3, 'descripcion' => 'Produccion', 'activo' => 1]
        ];

        foreach ($niveles as $nivel) {

            Nivel::create($nivel);
        }
    }
}
