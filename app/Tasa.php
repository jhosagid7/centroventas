<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasa extends Model
{
    public $timestamps = true;
    protected $fillabel = [
        'nombre',
        'tasa',
        'porcentaje_ganancia',
        'estado',
        'caja'
    ];

    protected $guarded = [];
}
// 'api_token' => str_random(50)