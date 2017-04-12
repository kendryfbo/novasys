<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = [
            'user' => 'kendryfbo',
            'nombre' => 'Kendry Finol',
            'area' => 'Informatica',
            'role_id' => 1,
            'password' => Hash::make('1234')
        ];
        Usuario::create($usuario);
    }
}
