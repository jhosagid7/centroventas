<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoServicio extends Model
{
    protected $fillabel = [
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'MontoDolar',
        'Vueltos',
        'servicio_id',
        'caja_id'
    ];

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
