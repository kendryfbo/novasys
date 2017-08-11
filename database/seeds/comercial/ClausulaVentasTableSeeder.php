<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\ClausulaVenta;
class ClausulaVentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $clausulas = [
        ['nombre' => 'C.I.F', 'descripcion' => 'Cost, Insurance and Freight', 'activo' => 1],
        ['nombre' => 'FOB', 'descripcion' => 'Free On Board', 'activo' => 1],
        ['nombre' => 'CFR', 'descripcion' => 'Cost and Freight ', 'activo' => 0],
        ['nombre' => 'DDP', 'descripcion' => 'Delivered Duty Paid', 'activo' => 0]
      ];

      foreach ($clausulas as $clausula) {

        ClausulaVenta::create($clausula);
      }

    }
}
