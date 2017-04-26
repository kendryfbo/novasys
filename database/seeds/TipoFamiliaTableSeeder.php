<?php

use Illuminate\Database\Seeder;
use App\Models\TipoFamilia;
class TipoFamiliaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposDeFamilias = [
            ['descripcion' => 'Insumo (MP)','activo' => 1],
            ['descripcion' => 'Pre-Proceso (PP)','activo' => 1],
            ['descripcion' => 'Producto Externo (PE)','activo' => 1],
            ['descripcion' => 'Producto Terminado (PT)','activo' => 1],
            ['descripcion' => 'Activos (AC)','activo' => 1],
            ['descripcion' => 'Repuestos (RP)','activo' => 1],
            ['descripcion' => 'Articulos de Oficina (AO)','activo' => 1],
            ['descripcion' => 'Otros (OO)','activo' => 1],
            ['descripcion' => 'Materiales P.O.P (PO)','activo' => 1]
        ];

        foreach ($tiposDeFamilias as $familia) {
            TipoFamilia::create($familia);
        }
    }
}
