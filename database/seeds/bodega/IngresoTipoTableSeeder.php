<?php

use Illuminate\Database\Seeder;
use App\Models\Bodega\IngresoTipo;

class IngresoTipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ['id' => 1, 'descripcion' => 'Manual', 'activo'=> 1],
            ['id' => 2, 'descripcion' => 'Termino de Proceso', 'activo'=> 1],
            ['id' => 3, 'descripcion' => 'Orden de Compra', 'activo'=> 1],
            ['id' => 4, 'descripcion' => 'Devolucion', 'activo'=> 1],
        ];

        foreach ($tipos as $tipo) {

            IngresoTipo::create($tipo);
        }
    }
}
