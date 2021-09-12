<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denominacion extends Model
{
    protected $fillabel     = [
        'modeda',
        'tipo',
        'valor',
        'denominacion'

    ];

    //Ahora especificamos los campos guarded
    protected $guarded=[];
}
