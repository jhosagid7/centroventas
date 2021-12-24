<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Articulo_venta extends Model
{
    protected $fillabel = [
    'cantidad',
    'precio_costo_unidad',
    'precio_venta_unidad',
    'porEspecial',
    'isDolar',
    'isPeso',
    'isTransPunto',
    'isMixto',
    'isEfectivo',
    'descuento',
    'articulo_id',
    'venta_id'
    ];



    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function articulo(){
        return $this->belongsTo(Articulo::class);
    }


    public function scopefecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio.' 00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin.' 23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('articulo_ventas.created_at', [$fecha_inicio, $fecha_fin]);
        }
    }

    public function scopeTipo($query, $tipo){
        if($tipo)
        return $query->where('articulos.vender_al', 'LIKE', "$tipo");
    }
}

