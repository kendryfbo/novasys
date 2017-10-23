<?php

use Illuminate\Database\Seeder;
use App\Models\Bodega\PosicionStatus;

class PosicionStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusAll = [
            ['id' => 1, 'descripcion' => 'deshabilitado', 'activo'=> 1],
            ['id' => 2, 'descripcion' => 'disponible', 'activo'=> 1],
            ['id' => 3, 'descripcion' => 'ocupado', 'activo'=> 1],
            ['id' => 4, 'descripcion' => 'reservado', 'activo'=> 1]
        ];

        foreach ($statusAll as $status) {

            PosicionStatus::create($status);
        }
    }
}
