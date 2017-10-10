<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\MedioTransporte;

class MedioTransporteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mediosTransporte = [
        ['descripcion' => 'Maritimo', 'activo' => 1],
        ['descripcion' => 'Aereo', 'activo' => 1],
        ['descripcion' => 'Terrestre', 'activo' => 1]
      ];

      foreach ($mediosTransporte as $medioTransporte) {

        MedioTransporte::Create($medioTransporte);
      }
    }
}
