<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $fillabel = [
        'nombre_cuenta',
        'numero_cuenta',
        'moneda',
        'simbolo'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function saldos(){
        return $this->hasMany(SaldosMovimiento::class);
    }

    public function transacciones()
    {
        return $this->hasManyThrough(Transaccion::class, SaldosMovimiento::class);
    }
}
