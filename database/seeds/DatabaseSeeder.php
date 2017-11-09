<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Semillas de Modulo Desarrollo
        $this->call(TipoFamiliaTableSeeder::class);
        $this->call(FamiliaTableSeeder::class);
        $this->call(MarcasTableSeeder::class);
        $this->call(FormatoTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(SaboresTableSeeder::class);
        $this->call(NivelesTableSeeder::class);

        // Semillas de Modulo Comercial
        $this->call(CanalTableSeeder::class);
        $this->call(CentroVentaTableSeeder::class);
        $this->call(ClausulaVentasTableSeeder::class);
        $this->call(ClientesNacionalesTableSeeder::class);
        $this->call(ComunasTableSeeder::class);
        $this->call(FormaPagoNacTableSeeder::class);
        $this->call(FormaPagoIntlTableSeeder::class);
        $this->call(IdiomasTableSeeder::class);
        $this->call(ImpuestoTableSeeder::class);
        $this->call(MedioTransporteTableSeeder::class);
        $this->call(PaisTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(PuertoEmbarqueTableSeeder::class);
        $this->call(RegionesTableSeeder::class);
        $this->call(VendedoresTableSeeder::class);
        $this->call(ZonasTableSeeder::class);
        //$this->call(ClientesNacionalesTableSeeder::class); Por llenar semilla

        // Semillas de Modulo configuracion
        $this->call(AccesosTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);

        // Semillas de Modulo Bodega
        $this->call(IngresoTipoTableSeeder::class);
        $this->call(PosCondTipoTableSeeder::class);
        $this->call(PosicionStatusTableSeeder::class);

    }
}
