<?php

use Illuminate\Database\Seeder;
use App\Models\Adquicicion\OrdenCompraStatus;

class OrdenCompraStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusOC = [
            ['id' => 1, 'descripcion' => 'Pendiente', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Ingresada', 'activo' => 1],
            ['id' => 3, 'descripcion' => 'Completa', 'activo' => 1],
        ];

        foreach ($statusOC as $status) {

            OrdenCompraStatus::create($status);
        }
    }
}
