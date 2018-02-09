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
        ['id' => 1,'nombre' => 'C.I.F', 'descripcion' => 'Cost, Insurance and Freight', 'activo' => 1],
        ['id' => 2,'nombre' => 'FOB', 'descripcion' => 'Free On Board', 'activo' => 1],
        ['id' => 3,'nombre' => 'CFR', 'descripcion' => 'Cost and Freight ', 'activo' => 0],
        ['id' => 4,'nombre' => 'DDP', 'descripcion' => 'Delivered Duty Paid', 'activo' => 0]
      ];

      foreach ($clausulas as $clausula) {

        ClausulaVenta::create($clausula);
      }

    }
}
