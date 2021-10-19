<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlStock extends Model
{
    protected $fillabel = [
        'name',
        'stock_inicio',
        'stock_cierre',
        'stock_dif',
        'stock_cierre_operador',
        'observaciones',
        'user_id',
        'articulo_id',
        'caja_id'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];
}
