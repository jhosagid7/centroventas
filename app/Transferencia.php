<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $fillabel     = [
        'accion',
        'origenNombreProducto',
        'origenStockInicial',
        'origenStockFinal',
        'origenUnidades',
        'origenVender_al',
        'cantidadRestarOrigen',
        'destinoNombreProducto',
        'destinoStockInicial',
        'destinoStockFinal',
        'destinoUnidades',
        'destinoVender_al',
        'cantidadSumarDestino',
        'operador'
    ];

    protected $guarded=[];

    public function scopeNombre($query, $nombre){
        if($nombre)
        return $query->where('origenNombreProducto', 'LIKE', "%$nombre%");
    }

    public function scopeAccion($query, $accion){
        if($accion)
        return $query->where('accion', 'LIKE', "$accion");
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
