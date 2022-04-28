<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoIngreso extends Model
{
    protected $fillabel = [
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'TasaRecived',
        'MontoDolar',
        'Vueltos',
        'ingreso_id',
        'caja_id'
    ];

    public function ingreso(){
        return $this->belongsTo(Ingreso::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
