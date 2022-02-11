<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCreditoIngreso extends Model
{
    protected $fillabel     = [
        'ingreso_id',
        'proveedor',
        'operador',
        'caja',
        'moto',
        'abono',
        'resta',
        'descuento',
        'incremento'

    ];

    protected $guarded=[];

    public function Ingreso()
    {
        return $this->belongsTo(Ingreso::class);
    }

    public function Proveedor()
    {
        return $this->belongsTo(Persona::class);
    }

    public function Operador()
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
