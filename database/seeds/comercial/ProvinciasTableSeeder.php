<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Provincia;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provincias = [
            ['id' => 1,  'descripcion' => 'Arica', 'region_id' => 1],
            ['id' => 2,  'descripcion' => 'Parinacota', 'region_id' => 1],
            ['id' => 3,  'descripcion' => 'Iquique', 'region_id' => 2],
            ['id' => 4,  'descripcion' => 'Tamarugal', 'region_id' => 2],
            ['id' => 5,  'descripcion' => 'Antofagasta', 'region_id' => 3],
            ['id' => 6,  'descripcion' => 'El Loa', 'region_id' => 3],
            ['id' => 7,  'descripcion' => 'Tocopilla  ', 'region_id' => 3],
            ['id' => 8,  'descripcion' => 'Copiapó', 'region_id' => 4],
            ['id' => 9,  'descripcion' => 'Chañaral', 'region_id' => 4],
            ['id' => 10,  'descripcion' => 'Huasco', 'region_id' => 4],
            ['id' => 11,  'descripcion' => 'Elqui', 'region_id' => 5],
            ['id' => 12,  'descripcion' => 'Choapa', 'region_id' => 5],
            ['id' => 13,  'descripcion' => 'Limari', 'region_id' => 5],
            ['id' => 14,  'descripcion' => 'Valparaíso  ', 'region_id' => 6],
            ['id' => 15,  'descripcion' => 'Isla de Pascua  ', 'region_id' => 6],
            ['id' => 16,  'descripcion' => 'Los Andes  ', 'region_id' => 6],
            ['id' => 17,  'descripcion' => 'Petorca', 'region_id' => 6],
            ['id' => 18,  'descripcion' => 'Quillota', 'region_id' => 6],
            ['id' => 19,  'descripcion' => 'San Antonio', 'region_id' => 6],
            ['id' => 20,  'descripcion' => 'San Felipe', 'region_id' => 6],
            ['id' => 21,  'descripcion' => 'Marga Marga', 'region_id' => 6],
            ['id' => 22,  'descripcion' => 'Cachapoal', 'region_id' => 7],
            ['id' => 23,  'descripcion' => 'Cardenal Caro', 'region_id' => 7],
            ['id' => 24,  'descripcion' => 'Colchagua', 'region_id' => 7],
            ['id' => 25,  'descripcion' => 'Talca', 'region_id' => 8],
            ['id' => 26,  'descripcion' => 'Cauquenes', 'region_id' => 8],
            ['id' => 27,  'descripcion' => 'Curico', 'region_id' => 8],
            ['id' => 28,  'descripcion' => 'Linares', 'region_id' => 8],
            ['id' => 29,  'descripcion' => 'Concepción', 'region_id' => 9],
            ['id' => 30,  'descripcion' => 'Arauco', 'region_id' => 9],
            ['id' => 31,  'descripcion' => 'Bío- Bío', 'region_id' => 9],
            ['id' => 32,  'descripcion' => 'Ñuble', 'region_id' => 9],
            ['id' => 33,  'descripcion' => 'Cautín', 'region_id' => 10],
            ['id' => 34,  'descripcion' => 'Malleco', 'region_id' => 10],
            ['id' => 35,  'descripcion' => 'Valdivia', 'region_id' => 11],
            ['id' => 36,  'descripcion' => 'Ranco', 'region_id' => 11],
            ['id' => 37,  'descripcion' => 'Llanquihue', 'region_id' => 12],
            ['id' => 38,  'descripcion' => 'Chiloe', 'region_id' => 12],
            ['id' => 39,  'descripcion' => 'Osorno  ', 'region_id' => 12],
            ['id' => 40,  'descripcion' => 'Palena', 'region_id' => 12],
            ['id' => 41,  'descripcion' => 'Coihaique  ', 'region_id' => 13],
            ['id' => 42,  'descripcion' => 'Aisén', 'region_id' => 13],
            ['id' => 43,  'descripcion' => 'Capitan Prat', 'region_id' => 13],
            ['id' => 44,  'descripcion' => 'General Carrera', 'region_id' => 13],
            ['id' => 45,  'descripcion' => 'Magallanes', 'region_id' => 14],
            ['id' => 46,  'descripcion' => 'Antártica Chilena', 'region_id' => 14],
            ['id' => 47,  'descripcion' => 'Tierra del Fuego', 'region_id' => 14],
            ['id' => 48,  'descripcion' => 'Ultima Esperanza', 'region_id' => 14],
            ['id' => 49,  'descripcion' => 'Santiago', 'region_id' => 15],
            ['id' => 50,  'descripcion' => 'Cordillera', 'region_id' => 15],
            ['id' => 51,  'descripcion' => 'Chacabuco', 'region_id' => 15],
            ['id' => 52,  'descripcion' => 'Maipo', 'region_id' => 15],
            ['id' => 53,  'descripcion' => 'melipilla', 'region_id' => 15],
            ['id' => 54,  'descripcion' => 'Talagante', 'region_id' => 15],
        ];

        foreach ($provincias as $provincia) {

            Provincia::create($provincia);
        };
    }
}
