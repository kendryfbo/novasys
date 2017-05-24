<?php

use Illuminate\Database\Seeder;
use App\Models\Formato;
class FormatoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formatos = [
            ['descripcion' => '1x8x55g', 'unidad_med' => 'g', 'peso' => 55, 'sobre' => 8, 'display' => 1, 'activo' => 1],
            ['descripcion' => '8x3x170g', 'unidad_med' => 'g', 'peso' => 170, 'sobre' => 3, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x24x2.5g', 'unidad_med' => 'g', 'peso' => 2.5, 'sobre' => 24, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x20x20g', 'unidad_med' => 'g', 'peso' => 20, 'sobre' => 20, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x20x10g', 'unidad_med' => 'g', 'peso' => 10, 'sobre' => 20, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x18x20g', 'unidad_med' => 'g', 'peso' => 20, 'sobre' => 18, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x12x10g', 'unidad_med' => 'g', 'peso' => 10, 'sobre' => 12, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x10x8g', 'unidad_med' => 'g', 'peso' => 8, 'sobre' => 10, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x10x45g', 'unidad_med' => 'g', 'peso' => 45, 'sobre' => 10, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x10x20g', 'unidad_med' => 'g', 'peso' => 20, 'sobre' => 10, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x10x12g', 'unidad_med' => 'g', 'peso' => 12, 'sobre' => 10, 'display' => 8, 'activo' => 1],
            ['descripcion' => '8x10x10g', 'unidad_med' => 'g', 'peso' => 10, 'sobre' => 10, 'display' => 8, 'activo' => 1],
            ['descripcion' => '1x6x900g', 'unidad_med' => 'g', 'peso' => 900, 'sobre' => 6, 'display' => 1, 'activo' => 1],
            ['descripcion' => '6x7x55g', 'unidad_med' => 'g', 'peso' => 55, 'sobre' => 7, 'display' => 6, 'activo' => 1],
            ['descripcion' => '1x6x521g', 'unidad_med' => 'g', 'peso' => 521, 'sobre' => 6, 'display' => 1, 'activo' => 1],
            ['descripcion' => '1x6x500g', 'unidad_med' => 'g', 'peso' => 500, 'sobre' => 6, 'display' => 1, 'activo' => 1],
            ['descripcion' => '6x4x2.5g', 'unidad_med' => 'g', 'peso' => 2.5, 'sobre' => 4, 'display' => 6, 'activo' => 1],
            ['descripcion' => '1x6x450g', 'unidad_med' => 'g', 'peso' => 450, 'sobre' => 6, 'display' => 1, 'activo' => 1],
            ['descripcion' => '1x6x400g', 'unidad_med' => 'g', 'peso' => 400, 'sobre' => 6, 'display' => 1, 'activo' => 1],
            ['descripcion' => '6x30x7g', 'unidad_med' => 'g', 'peso' => 7, 'sobre' => 30, 'display' => 6, 'activo' => 1],
            ['descripcion' => '6x30x20g', 'unidad_med' => 'g', 'peso' => 20, 'sobre' => 30, 'display' => 6, 'activo' => 1],
        ];

        foreach ($formatos as $formato) {

            Formato::create($formato);
        }

    }
}
