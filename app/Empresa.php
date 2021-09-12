<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
     //protected $timestamps   = false;
     public $timestamps =true;

     //Haora debemos especificar cuales son los atributos que deben recibir un valor para almacenar en nuestra tabla
     protected $fillabel = [
         'nombre',
         'slogan',
         'telefono_fijo',
         'telefono_mobil',
         'email',
         'direccion',
         'imagen_logo'
     ];

     //Haora especificamos los campos guarded
     protected $guarded = [];

     public function sucursals(){
        return $this->hasMany('App\Sucursal');
    }

    public function cajas()
    {
        return $this->hasManyThrough('App\Caja', 'App\Sucursal');
    }
}
