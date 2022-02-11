<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditoIngreso extends Model
{
    protected $fillabel = [
        'ingreso_id',
        'proveedor_credito_id',
        'estado_credito_ingreso'
    ];


    protected $guarded = [];


    // public function Cliente()
    // {
    //     return $this->belongsTo(Persona::class);
    // }

    public function ingreso(){
        return $this->belongsTo(Ingreso::class);
    }

    public function proveedor_credito(){
        return $this->belongsTo(ProveedorCredito::class);
    }

}
