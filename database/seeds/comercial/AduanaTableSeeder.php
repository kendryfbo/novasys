<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Aduana;
class AduanaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aduanas = [
            ['id' => 1, 'rut' => '89848400-9', 'descripcion' => 'JORGE VIO ARIS', 'direccion' => 'ALAMEDA', 'ciudad' => 'SANTIAGO', 'comuna' => 'SANTIAGO', 'fono' => '9999', 'activo' => 1]
        ];

        foreach ($aduanas as $aduana) {

            Aduana::create($aduana);
        }
    }
}
