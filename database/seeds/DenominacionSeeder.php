<?php

use App\Denominacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenominacionSeeder extends Seeder
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
        Denominacion::truncate();

        //ahor habilitamos los freignKey
        DB::statement("SET foreign_key_checks=1");


        //creamos nuestro registro para la tasa Dolar $1, $2, $5, $10, $20, $50, $100
        //Tasa Dolar
        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'1',
            'denominacion'=>'Billete de 1 Dolar'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'2',
            'denominacion'=>'Billete de 2 Dolares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'5',
            'denominacion'=>'Billete de 5 Dolares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'10',
            'denominacion'=>'Billete de 10 Dolares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'20',
            'denominacion'=>'Billete de 20 Dolares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'50',
            'denominacion'=>'Billete de 50 Dolares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Dolar',
            'tipo'=>'Billete',
            'valor'=>'100',
            'denominacion'=>'Billete de 100 Dolares'
        ]);

        // denominacio de bolivares 2, 5, 10, 20, 50, 100, 200, 500, 10.000, 20.000 y 50.000 Bs.

        $Denominacion= Denominacion::create([
            'moneda'=>'Bolivares',
            'tipo'=>'Billete',
            'valor'=>'500',
            'denominacion'=>'Billete de 500 Bolivares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Bolivares',
            'tipo'=>'Billete',
            'valor'=>'10000',
            'denominacion'=>'Billete de 10.000 Bolivares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Bolivares',
            'tipo'=>'Billete',
            'valor'=>'20000',
            'denominacion'=>'Billete de 20.000 Bolivares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Bolivares',
            'tipo'=>'Billete',
            'valor'=>'50000',
            'denominacion'=>'Billete de 50.000 Bolivares'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Bolivares',
            'tipo'=>'Billete',
            'valor'=>'100000',
            'denominacion'=>'Billete de 100.000 Bolivares'
        ]);

        // denominacio de pesos monedas 50, 100, 200, 500, 1.000.

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Moneda',
            'valor'=>'50',
            'denominacion'=>'Moneda de 50 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Moneda',
            'valor'=>'100',
            'denominacion'=>'Moneda de 100 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Moneda',
            'valor'=>'200',
            'denominacion'=>'Moneda de 200 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Moneda',
            'valor'=>'500',
            'denominacion'=>'Moneda de 500 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Moneda',
            'valor'=>'1000',
            'denominacion'=>'Moneda de 1.000 Pesos'
        ]);

        // denominacio de pesos billetes 1.000, 2.000, 5.000, 10.000, 20.000, 50.000, 100.000 $.

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'1000',
            'denominacion'=>'Billete de 1.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'2000',
            'denominacion'=>'Billete de 2.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'5000',
            'denominacion'=>'Billete de 5.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'10000',
            'denominacion'=>'Billete de 10.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'20000',
            'denominacion'=>'Billete de 20.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'50000',
            'denominacion'=>'Billete de 50.000 Pesos'
        ]);

        $Denominacion= Denominacion::create([
            'moneda'=>'Pesos',
            'tipo'=>'Billete',
            'valor'=>'100000',
            'denominacion'=>'Billete de 100.000 Pesos'
        ]);



    }
}
