<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
     public $timestamps =true;

     protected $fillabel = [
         'nombre',
         'descripcion',
         'prefijo'
     ];

     protected $guarded = [];

     public function areas(){
        return $this->hasMany(Area::class);
    }
}
