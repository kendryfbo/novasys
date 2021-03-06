<?php

use Illuminate\Database\Seeder;
use App\Models\Config\StatusDocumento;

class StatusDocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusDocumentos = [
            ['id' => 1, 'descripcion' => 'Pendiente', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Ingresada', 'activo' => 1],
            ['id' => 3, 'descripcion' => 'Completa', 'activo' => 1],
        ];

        foreach ($statusDocumentos as $status) {

            StatusDocumento::create($status);
        }
    }
}
