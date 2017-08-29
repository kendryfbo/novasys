<?php

use Illuminate\Database\Seeder;
use App\Models\Sabor;

class SaboresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sabores = [
            ['descripcion' => 'Cereza', 'descrip_ing' => 'Cherry', 'activo' => 1],
            ['descripcion' => 'Citrus Punch', 'descrip_ing' => 'Citrus Punch', 'activo' => 1],
            ['descripcion' => 'Arandano', 'descrip_ing' => 'Cranberry', 'activo' => 1],
            ['descripcion' => 'Te - Durazno(Meloc.)', 'descrip_ing' => 'Iced Tea-Peach', 'activo' => 1],
            ['descripcion' => 'Exotic', 'descrip_ing' => 'Exotic', 'activo' => 1],
            ['descripcion' => 'Frutilla (Fresa)', 'descrip_ing' => 'Strawberry', 'activo' => 1],
            ['descripcion' => 'Fresa', 'descrip_ing' => 'Strawberry', 'activo' => 1],
            ['descripcion' => 'Guayaba', 'descrip_ing' => 'Guava', 'activo' => 1],
            ['descripcion' => 'Jamaica', 'descrip_ing' => 'Jamaica', 'activo' => 1],
            ['descripcion' => 'Limon', 'descrip_ing' => 'Lemon', 'activo' => 1],
            ['descripcion' => 'Limonada', 'descrip_ing' => 'Lemonade', 'activo' => 1],
            ['descripcion' => 'Mandarina ', 'descrip_ing' => 'Tangerine', 'activo' => 1],
            ['descripcion' => 'Mango', 'descrip_ing' => 'Mango', 'activo' => 1],
            ['descripcion' => 'Manzana', 'descrip_ing' => 'Apple', 'activo' => 1],
            ['descripcion' => 'Maracuya', 'descrip_ing' => 'Passion fruit', 'activo' => 1],
            ['descripcion' => 'Melon', 'descrip_ing' => 'Cantaloupe', 'activo' => 1],
            ['descripcion' => 'Mora', 'descrip_ing' => 'Blackberry', 'activo' => 1],
            ['descripcion' => 'Naranja', 'descrip_ing' => 'Orange', 'activo' => 1],
            ['descripcion' => 'Piña', 'descrip_ing' => 'Pineapple', 'activo' => 1],
            ['descripcion' => 'Sandia', 'descrip_ing' => 'Watermelon', 'activo' => 1],
            ['descripcion' => 'Sky apple', 'descrip_ing' => 'Sky apple', 'activo' => 1],
            ['descripcion' => 'Surtido', 'descrip_ing' => 'Assorted', 'activo' => 1],
            ['descripcion' => 'Tamarindo', 'descrip_ing' => 'Tamarind', 'activo' => 1],
            ['descripcion' => 'Toronja', 'descrip_ing' => 'Grapefruit', 'activo' => 1],
            ['descripcion' => 'Tutti fruti', 'descrip_ing' => 'Fruit Punch', 'activo' => 1],
            ['descripcion' => 'Uva', 'descrip_ing' => 'Grape', 'activo' => 1],
            ['descripcion' => 'Frutas Mezcladas', 'descrip_ing' => 'Fruit Mix', 'activo' => 1],
            ['descripcion' => 'Piña-Guayaba', 'descrip_ing' => 'Pineapple-Guava', 'activo' => 1],
            ['descripcion' => 'Lima limón', 'descrip_ing' => 'Lemon Lime', 'activo' => 1],
            ['descripcion' => 'Frambuesa', 'descrip_ing' => 'Raspberry', 'activo' => 1],
            ['descripcion' => 'Sin Sabor', 'descrip_ing' => 'No flavor', 'activo' => 1],
            ['descripcion' => 'Bayas', 'descrip_ing' => 'Berries', 'activo' => 1],
            ['descripcion' => 'Ponche Caribeño', 'descrip_ing' => 'Caribean Punch', 'activo' => 1],
            ['descripcion' => 'Dulce de Leche', 'descrip_ing' => 'Milk Caramel', 'activo' => 1],
            ['descripcion' => 'Cheesecake Fresa', 'descrip_ing' => 'Strawberry Cheesecak', 'activo' => 1],
            ['descripcion' => 'Vainilla', 'descrip_ing' => 'Vanilla', 'activo' => 1],
            ['descripcion' => 'Cranberry Breeze', 'descrip_ing' => 'Cranberry Breeze', 'activo' => 1],
            ['descripcion' => 'Exotic Berries', 'descrip_ing' => 'Exotic Berries', 'activo' => 1],
            ['descripcion' => 'Durazno (Melocoton)', 'descrip_ing' => 'Peach', 'activo' => 1],
            ['descripcion' => 'Chocolate', 'descrip_ing' => 'Chocolate', 'activo' => 1],
            ['descripcion' => 'Te - Miel y Limon', 'descrip_ing' => 'Iced Tea Honey/Lemon', 'activo' => 1],
            ['descripcion' => 'Manjar', 'descrip_ing' => 'Manjar', 'activo' => 1],
            ['descripcion' => 'Te-Limon', 'descrip_ing' => 'Iced Tea Lemon', 'activo' => 1],
            ['descripcion' => 'Guinda', 'descrip_ing' => 'Cherry', 'activo' => 1],
            ['descripcion' => 'Lucuma', 'descrip_ing' => 'Lucumi', 'activo' => 1],
            ['descripcion' => 'Cacao', 'descrip_ing' => 'Cocoa', 'activo' => 1],
            ['descripcion' => 'Fructosa', 'descrip_ing' => 'Fructose', 'activo' => 1],
            ['descripcion' => 'Energizante', 'descrip_ing' => 'Energy', 'activo' => 1],
            ['descripcion' => 'Horchata', 'descrip_ing' => 'Horchata', 'activo' => 1],
            ['descripcion' => 'Energy', 'descrip_ing' => 'Energy', 'activo' => 1],
            ['descripcion' => 'Cola', 'descrip_ing' => 'Cola', 'activo' => 1],
            ['descripcion' => 'AVELLANA', 'descrip_ing' => 'AVELLANA', 'activo' => 1],
            ['descripcion' => 'Moka', 'descrip_ing' => 'Moka', 'activo' => 1],
            ['descripcion' => 'CLASICO', 'descrip_ing' => 'CLASICO', 'activo' => 1],
            ['descripcion' => 'CREMA DE WHISKY', 'descrip_ing' => 'CREMA DE WHISKY', 'activo' => 1],
            ['descripcion' => 'Arandano', 'descrip_ing' => 'Cranberry', 'activo' => 1],
            ['descripcion' => 'Mix Berries', 'descrip_ing' => 'Mix Berries', 'activo' => 1],
            ['descripcion' => 'Naranja y Piña', 'descrip_ing' => 'Orange & Pineapple', 'activo' => 1],
            ['descripcion' => 'Durazno y Piña', 'descrip_ing' => 'Peach & Pineapple', 'activo' => 1],
            ['descripcion' => 'Naranja y Durazno', 'descrip_ing' => 'Orange & Peach', 'activo' => 1],
            ['descripcion' => 'Naranja/Piña', 'descrip_ing' => 'Orange/Pineapple', 'activo' => 1],
            ['descripcion' => 'Naranja/Zanahoria', 'descrip_ing' => 'Orange/Carrot', 'activo' => 1],
            ['descripcion' => 'Piña Colada', 'descrip_ing' => 'Pina Colada', 'activo' => 1],
            ['descripcion' => 'Granada', 'descrip_ing' => 'Pomegranate', 'activo' => 1],
            ['descripcion' => 'Pera', 'descrip_ing' => 'Pear', 'activo' => 1],
            ['descripcion' => 'Damasco', 'descrip_ing' => 'Apricot', 'activo' => 1],
            ['descripcion' => 'Mix Frutal', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Papaya', 'descrip_ing' => 'Papaya', 'activo' => 1],
            ['descripcion' => 'Berries', 'descrip_ing' => 'Berries', 'activo' => 1],
            ['descripcion' => 'Melón Tuna', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Quasavisco', 'descrip_ing' => 'Quasavisco', 'activo' => 1],
            ['descripcion' => 'Coco', 'descrip_ing' => 'Coconut', 'activo' => 1],
            ['descripcion' => 'Guanábana', 'descrip_ing' => 'Soursop', 'activo' => 1],
            ['descripcion' => 'Piña-Jengibre', 'descrip_ing' => 'Pineapple-Ginger', 'activo' => 1],
            ['descripcion' => 'Piña-Coco', 'descrip_ing' => 'Pineapple-Coconut', 'activo' => 1],
            ['descripcion' => 'Naranja/Frutilla', 'descrip_ing' => 'Orange/Strawberry', 'activo' => 1],
            ['descripcion' => 'Maqui-Grape', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Huesillo', 'descrip_ing' => 'Huesillo', 'activo' => 1],
            ['descripcion' => 'Fresa-Banana', 'descrip_ing' => 'Strawberry-Banana', 'activo' => 1],
            ['descripcion' => 'NAR-PIÑ-FRE-UVA-MARA', 'descrip_ing' => 'ORA-PIN-STR-GRA-PAS', 'activo' => 1],
            ['descripcion' => 'Cereza-Piña', 'descrip_ing' => 'Cherry-Pineapple', 'activo' => 1],
            ['descripcion' => 'Frutos Rojos', 'descrip_ing' => 'Berries', 'activo' => 1],
            ['descripcion' => 'Blue berry lagoon', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Purple passion punch', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Jamaica - Jengibre', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Naranja-Banana', 'descrip_ing' => 'Orange-Banana', 'activo' => 1],
            ['descripcion' => 'Pera de agua', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Mango-maracuyá', 'descrip_ing' => '', 'activo' => 1],
            ['descripcion' => 'Pepino-Menta', 'descrip_ing' => 'Cucumber-Mint', 'activo' => 1],
            ['descripcion' => 'Dandia-Fresa', 'descrip_ing' => 'Watermelon-Strawberr', 'activo' => 1],
            ['descripcion' => 'Kiwi-Frambuesa', 'descrip_ing' => 'Kiwi-Raspberry', 'activo' => 1],
            ['descripcion' => 'Sandia-Fresa', 'descrip_ing' => 'Watermelon-Strawberr', 'activo' => 1],
            ['descripcion' => 'Chirimoya Alegre', 'descrip_ing' => 'Custard Apple-Orange', 'activo' => 1],
            ['descripcion' => 'Surtido (Caso S)', 'descrip_ing' => 'assortment (Case S)', 'activo' => 1],
            ['descripcion' => 'Surtido (Caso T)', 'descrip_ing' => 'Assortment (Case T)', 'activo' => 1],
            ['descripcion' => 'Surtido (Caso F)', 'descrip_ing' => 'Assortment (Case F)', 'activo' => 1],
        ];

        foreach ($sabores as $sabor) {

            Sabor::create($sabor);
        }
    }
}
