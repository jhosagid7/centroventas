<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionesBanco extends Model
{
    protected $fillabel = [
        'concepto',
        'banco_origen',
        'banco_destiono',
        'tasa_destino',
        'saldo_banco_dolar',
        'saldo_banco_peso',
        'saldo_banco_punto',
        'saldo_banco_bolivar',
        'monto_debitar',
        'monto_transferir',
        'operador',
        'caja_id'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
