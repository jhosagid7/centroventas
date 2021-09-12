<?php


use App\Persona;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");

        //hacemos truncate a las tablas que tienen modelos pero con eloquent
        Persona::truncate();

        //ahor habilitamos los freignKey
        DB::statement("SET foreign_key_checks=1");

        $sucursal = Persona::create([
            'tipo_persona' => 'Proveedor',
            'nombre' => 'Proveedor Comun',
            'tipo_documento' => 'RIF-',
            'num_documento' => 'S/N',
            'direccion' => 'S/D',
            'telefono' => 'S/T',
            'email' => 'S/E',
            'imagen' => 'avatar5.png'
        ]);

        $sucursal = Persona::create([
            'tipo_persona' => 'Cliente',
            'nombre' => 'Cliente Comun',
            'tipo_documento' => 'RIF-',
            'num_documento' => 'S/N',
            'direccion' => 'S/D',
            'telefono' => 'S/T',
            'email' => 'S/E',
            'imagen' => 'avatar3.png'
        ]);
    }
}

