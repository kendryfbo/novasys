<?php

use Illuminate\Database\Seeder;
use App\Models\Familia;
class FamiliaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias = [
            ['codigo' => 'PRE','descripcion' => 'Premezclas','tipo_id' => 2,'activo' => 1],
            ['codigo' => 'MP1','descripcion' => 'Endulzantes','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'MP4','descripcion' => 'Colorante','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'MP3','descripcion' => 'Acidos y Sales','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'MP5','descripcion' => 'Otros Ingredientes','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'ENV','descripcion' => 'Envase Primario','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'ENS','descripcion' => 'Envase Secundario','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'CIN','descripcion' => 'Cintas','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'BAS','descripcion' => 'BASES','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'BEB','descripcion' => 'Bebidas','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'REF','descripcion' => 'Refrescos','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'TEF','descripcion' => 'Te Frio','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'POS','descripcion' => 'Postres','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'POP','descripcion' => 'Materiales','tipo_id' => 9,'activo' => 1],
            ['codigo' => 'CON','descripcion' => 'Confites','tipo_id' => 3,'activo' => 1],
            ['codigo' => 'OTR','descripcion' => 'Otros','tipo_id' => 3,'activo' => 1],
            ['codigo' => 'MP2','descripcion' => 'Sabores y Aromas','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'SAB','descripcion' => 'Saborizante','tipo_id' => 4,'activo' => 1],
            ['codigo' => 'REP','descripcion' => 'Repuestos Maquinaria','tipo_id' => 6,'activo' => 1],
            ['codigo' => 'OFI','descripcion' => 'Articulos de Oficina','tipo_id' => 7,'activo' => 1],
            ['codigo' => 'MAN','descripcion' => 'Materiales Mantencion','tipo_id' => 7,'activo' => 1],
            ['codigo' => 'OMP','descripcion' => 'Otras Materias Primas','tipo_id' => 1,'activo' => 1],
            ['codigo' => 'RPC','descripcion' => 'Reprocesos','tipo_id' => 1,'activo' => 1],
            ['codigo' => '10','descripcion' => 'Vestuario','tipo_id' => 9,'activo' => 1],
            ['codigo' => '20','descripcion' => 'Articulo de Oficina','tipo_id' => 9,'activo' => 1],
            ['codigo' => '30','descripcion' => 'Accesorios','tipo_id' => 9,'activo' => 1],
            ['codigo' => '40','descripcion' => 'Marketing','tipo_id' => 9,'activo' => 1]
        ];

        foreach ($familias as $familia) {
            Familia::create($familia);
        }
    }
}
