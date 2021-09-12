<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'nombre',
        'telefono_fijo',
        'telefono_mobil',
        'telefono_mobil',
        'direccion',
        'estado',
        'empresa_id'
    ];

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }

    public function cajas()
    {
        return $this->hasMany('App\Caja');
    }


}
