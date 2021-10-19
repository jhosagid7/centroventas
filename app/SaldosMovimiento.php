<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosMovimiento extends Model
{
    protected $fillabel = [
        'correlativo',
        'debe',
        'haber',
        'saldo',
        'cuenta_id',
        'transaccion_id'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function Cuenta(){
        return $this->belongsTo(Cuenta::class);
    }

    public function Transaccion(){
        return $this->belongsTo(Transaccion::class);
    }
}
