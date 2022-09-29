<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $timestamps =true;

     protected $fillabel = [
         'area',
         'descripcion',
         'area_id'
     ];

     protected $guarded = [];

     public function Aritculos(){
        return $this->hasMany(Articulo::class);
    }

    public function deposito(){
        return $this->belongsTo(Deposito::class);
    }
}
