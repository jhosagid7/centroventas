<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo_Ingreso extends Model
{

    public function ingreso()
    {
        return $this->belongsTo(Ingreso::class);
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }

    protected $fillabel = [
        'cantidad',
        'precio_costo_unidad',
        'ingreso_id',
        'articulo_id'
    ];


    protected $guarded = [];
}
