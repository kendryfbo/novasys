<?php

use Illuminate\Database\Seeder;
use App\Models\Bodega\PosCondTipo;

class PosCondTipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoCondiciones = [
            ['id' => 1, 'descripcion' => 'Tipo Familia', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Familia', 'activo' => 1],
            ['id' => 3, 'descripcion' => 'Marca', 'activo' => 1],
            ['id' => 4, 'descripcion' => 'Producto', 'activo' => 1],
            ['id' => 5, 'descripcion' => 'Insumo', 'activo' => 1],
        ];

        foreach ($tipoCondiciones as $tipo) {

            PosCondTipo::create($tipo);
        }
    }
}
