<?php

use Illuminate\Database\Seeder;
use App\Models\Bodega\PalletMedida;
class PalletMedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medidas = [
            ['id' => 1, 'descripcion' => 'Bajo', 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Alto', 'activo' => 1],
        ];

        foreach ($medidas as $medida) {

            PalletMedida::create($medida);
        }
    }
}
