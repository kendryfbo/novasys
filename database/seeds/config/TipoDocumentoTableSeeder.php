<?php

use Illuminate\Database\Seeder;
use App\Models\Config\TipoDocumento;

class TipoDocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $tipoDocumentos = [
        //Modulos Principales
        ['id' => 1, 'descripcion' => 'Proforma', 'activo' => 1],
        ['id' => 2, 'descripcion' => 'Nota Venta', 'activo' => 1],
        ['id' => 3, 'descripcion' => 'Ingreso Manual', 'activo' => 1],
        ['id' => 4, 'descripcion' => 'Egreso Manual', 'activo' => 1],
        ];

      foreach ($tipoDocumentos as $tipo) {

        TipoDocumento::create($tipo);
      }
    }
}
