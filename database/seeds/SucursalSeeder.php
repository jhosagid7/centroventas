<?php

use App\Sucursal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //limpiar las tablas antes de llenarlas (truncate)
        //primero desactivamos las restricciones de llaves foranias
        DB::statement("SET foreign_key_checks=0");

        //hacemos truncate a las tablas que tienen modelos pero con eloquent
        Sucursal::truncate();

        //ahor habilitamos los freignKey
        DB::statement("SET foreign_key_checks=1");

        $sucursal = Sucursal::create([
            'nombre' => 'Centro',
            'telefono_fijo' => '0424-7665227',
            'telefono_mobil' => '0424-7665227',
            'direccion' => 'Calle #3 El Vigía.',
            'estado' => 'Activa',
            'empresa_id' => 1
        ]);


    }
}
