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
            ['id' => 1, 'descripcion' => 'Insumo (MP)','activo' => 1],
            ['id' => 2, 'descripcion' => 'Pre-Proceso (PP)','activo' => 1],
            ['id' => 3, 'descripcion' => 'Producto Externo (PE)','activo' => 1],
            ['id' => 4, 'descripcion' => 'Producto Terminado (PT)','activo' => 1],
            ['id' => 5, 'descripcion' => 'Premezcla (PR)','activo' => 1],
            ['id' => 6, 'descripcion' => 'Activos (AC)','activo' => 1],
            ['id' => 7, 'descripcion' => 'Repuestos (RP)','activo' => 1],
            ['id' => 8, 'descripcion' => 'Articulos de Oficina (AO)','activo' => 1],
            ['id' => 9, 'descripcion' => 'Otros (OO)','activo' => 1],
            ['id' => 10,'descripcion' => 'Materiales P.O.P (PO)','activo' => 1]
        ];

        foreach ($tiposDeFamilias as $familia) {
            TipoFamilia::create($familia);
        }
    }
}
