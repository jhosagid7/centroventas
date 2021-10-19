<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $fillabel = [
        'correlativo',
        'descripcion_op',
        'codigo',
        'denominacion',
        'operador'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function saldos(){
        return $this->hasMany(SaldosMovimiento::class);
    }
}
