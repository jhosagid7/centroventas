<?php

use App\Tasa;
use Illuminate\Database\Seeder;

class TasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //hacemos truncate a las tablas que tienen modelos pero con eloquent
         Tasa::truncate();


         //creamos nuestro registro para la tasa Dolar
         //Tasa Dolar
         $TasaDolar=Tasa::create([
             'nombre'=>'Dolar',
             'tasa'=> 0,
             'porcentaje_ganancia'=>0,
             'estado'=>'Activo',
             'caja'=>'Cerrada'
         ]);

         //creamos nuestro registro para la tasa Peso
         //Tasa Peso
         $TasaPeso=Tasa::create([
             'nombre'=>'Peso',
             'tasa'=> 0,
             'porcentaje_ganancia'=>0,
             'estado'=>'Activo',
             'caja'=>'Cerrada'
         ]);

         //creamos nuestro registro para la tasa Transferencia_Punto
         //Tasa Transferencia_Punto
         $TasaTransferencia_Punto=Tasa::create([
             'nombre'=>'Transferencia_Punto',
             'tasa'=> 0,
             'porcentaje_ganancia'=>0,
             'estado'=>'Activo',
             'caja'=>'Cerrada'
         ]);

         //creamos nuestro registro para la tasa Mixto
         //Tasa Mixto
         $TasaMixto=Tasa::create([
             'nombre'=>'Mixto',
             'tasa'=> 0,
             'porcentaje_ganancia'=>0,
             'estado'=>'Activo',
             'caja'=>'Cerrada'
         ]);

         //creamos nuestro registro para la tasa Efectivo
         //Tasa Efectivo
         $TasaEfectivo=Tasa::create([
             'nombre'=>'Efectivo',
             'tasa'=> 0,
             'porcentaje_ganancia'=>0,
             'estado'=>'Activo',
             'caja'=>'Cerrada'
         ]);

         //creamos nuestro registro para la tasa EfectivoVenta
         //Tasa EfectivoVenta
         $TasaEfectivo=Tasa::create([
            'nombre'=>'EfectivoVenta',
            'tasa'=> 0,
            'porcentaje_ganancia'=>0,
            'estado'=>'Activo',
            'caja'=>'Cerrada'
        ]);
    }
}
