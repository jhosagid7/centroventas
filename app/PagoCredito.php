<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoCredito extends Model
{
    protected $fillabel = [
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'MontoDolar',
        'Vueltos',
        'venta_id',
        'caja_id'
    ];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
