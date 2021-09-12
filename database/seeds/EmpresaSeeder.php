<?php

use App\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
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
        Empresa::truncate();

        //ahor habilitamos los freignKey
        DB::statement("SET foreign_key_checks=1");


        //creamos nuestro registro para la tasa Dolar
        //Tasa Dolar
        $Empresa=Empresa::create([
            'nombre'=>'Villa Soft Punto',
            'slogan'=>'La mejor en precios bajos...!',
            'telefono_fijo'=>'0424-7665227',
            'telefono_mobil'=>'0424-7665227',
            'email'=>'villasoftpunto@gmail.com',
            'direccion'=>'EL Vigía.',
            'imagen_logo'=>'photo2.png'
        ]);
    }
}
