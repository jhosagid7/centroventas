<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcedentesRecibidosCajaActual extends Model
{
    protected $fillabel = [
        'Tipo',
        'Estado',
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'MontoDolar',
        'venta_id',
        'caja_id'
    ];



    protected $guarded = [];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
    public function venta(){
        return $this->belongsTo(Venta::class);
    }

}
