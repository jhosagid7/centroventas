<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    protected $table = 'detalle_pago';

    
    protected $primaryKey = 'iddetalle_pago';

    
    public $timestamps = false;

    
    protected $fillabel = [
        'idventa',
        'Divisa',
        'MontoDivisa',
        'TasaTiket',
        'MontoDolar',
        'Vueltos'
    ];

    
    protected $guarded = [];
}
