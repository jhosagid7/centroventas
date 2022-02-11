<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCreditoVenta extends Model
{
    protected $fillabel     = [
        'venta_id',
        'cliente',
        'operador',
        'caja',
        'moto',
        'abono',
        'resta',
        'descuento',
        'incremento'

    ];

    protected $guarded=[];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Persona::class);
    }

    public function operador()
    {
        return $this->belongsTo(User::class);
    }

    public function Caja()
    {
        return $this->belongsTo(Caja::class);
    }

    protected $dates = [
        'fecha_hora',
    ];
}
