<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CategoriaPago extends Model
{
    protected $fillabel     = [
        'nombre',
        'descripcion',
        'condicion'
    ];

    //Haora especificamos los campos guarded
    protected $guarded=[

    ];

    public function tipo_pagos(){
        return $this->hasMany(TipoPago::class);
    }

    public function categoria_pago(){
        return $this->hasMany(CategoriaPago::class);
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function scopeNombre($query, $nombre){
        if($nombre)
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }

    public function scopeDescription($query, $description){
        if($description)
        return $query->where('descripcion', 'LIKE', "%$description%");
    }

    public function scopeCondition($query, $condition){
        if($condition)
        return $query->where('condicion', 'LIKE', "$condition");
    }

    public function scopeFecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
        }
    }
}
