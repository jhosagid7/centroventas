<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoVuelto extends Model
{
    protected $fillabel = [
        'Tipo',
        'tipo_vuelto',
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'MontoDolar',
        'venta_id',
        'caja_id'
    ];



    protected $guarded = [];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function cajas(){
        return $this->belongsTo(Caja::class);
    }
}
