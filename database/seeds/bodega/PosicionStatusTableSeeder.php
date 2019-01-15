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
            ['id' => 1, 'descripcion' => 'Deshabilitado', 'activo'=> 1],
            ['id' => 2, 'descripcion' => 'Disponible', 'activo'=> 1],
            ['id' => 3, 'descripcion' => 'Ocupado', 'activo'=> 1],
            ['id' => 4, 'descripcion' => 'Reservado', 'activo'=> 1]
        ];

        foreach ($statusAll as $status) {

            PosicionStatus::create($status);
        }
    }
}
