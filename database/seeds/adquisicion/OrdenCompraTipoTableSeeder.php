<?php

use Illuminate\Database\Seeder;
use App\Models\Adquisicion\OrdenCompraTipo;

class OrdenCompraTipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposOC = [
            ['id' => 1, 'descripcion' => 'Boleta', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Honorario', 'activo' => 1],
            ['id' => 3, 'descripcion' => 'Factura', 'activo' => 1],
        ];

        foreach ($tiposOC as $tipo) {

            OrdenCompraTipo::create($tipo);
        }
    }
}
