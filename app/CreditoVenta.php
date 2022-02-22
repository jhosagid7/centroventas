<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditoVenta extends Model
{
    protected $fillabel = [
        'venta_id',
        'cliente_credito_id',
        'estado_credito_venta'
    ];


    protected $guarded = [];


    // public function Cliente()
    // {
    //     return $this->belongsTo(Persona::class);
    // }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function cliente_credito(){
        return $this->belongsTo(ClienteCredito::class);
    }
}
