<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillabel     = [
        'codigo',
        'fecha',
        'hora_cierre',
        'hora',
        'mes',
        'year',
        'monto_dolar',
        'monto_peso',
        'monto_bolivar',
        'monto_dolar_cierre',
        'monto_peso_cierre',
        'monto_bolivar_cierre',
        'monto_punto_cierre',
        'monto_trans_cierre',
        'monto_dolar_cierre_dif',
        'monto_peso_cierre_dif',
        'monto_bolivar_cierre_dif',
        'monto_punto_cierre_dif',
        'monto_trans_cierre_dif',
        'dolar_dolar_operador',
        'peso_dolar_operador',
        'punto_dolar_operador',
        'trans_dolar_operador',
        'efectivo_dolar_operador',
        'dolar_sistema',
        'peso_sistema',
        'punto_sistema',
        'trans_sistema',
        'efectivo_sistema',
        'total_sistema_reg',
        'total_operador_reg',
        'total_diferencia',
        'Observaciones',
        'estado',
        'caja',
        'tasaDolarOpen',
        'tasaDolarOpenPorcentajeGanancia',
        'tasaPesoOpen',
        'tasaPesoOpenPorcentajeGanancia',
        'tasaTransferenciaPuntoOpen',
        'tasaTransferenciaPuntoOpenPorcentajeGanancia',
        'tasaEfectivoOpen',
        'tasaEfectivoOpenPorcentajeGanancia',
        'tasaDolarClose',
        'tasaDolarClosePorcentajeGanancia',
        'tasaPesoClose',
        'tasaPesoClosePorcentajeGanancia',
        'tasaTransferenciaPuntoClose',
        'tasaTransferenciaPuntoClosePorcentajeGanancia',
        'tasaEfectivoClose',
        'tasaEfectivoClosePorcentajeGanancia',
        'tasaActualVenta',
        'margenActualVenta',
        'user_id',
        'sucursal_id',
        'sessioncaja_id'
    ];

    //Ahora especificamos los campos guarded
    protected $guarded=[];

    protected $dates = [
        'fecha',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function pago_creditos(){
        return $this->hasMany(PagoCredito::class);
    }

    public function pago_ventas()
    {
        return $this->hasMany(Pago_Venta::class);
    }

    public function personas()
    {
        return $this->hasManyThrough(Persona::class, Venta::class);
    }

    public function articulo_ventas()
    {
        return $this->hasManyThrough(Articulo_Venta::class, Venta::class);
    }

    //este metodo nos ba a verificar si existe una caja abierta en el modelo Caja
    public static function buscarCaja() {
        // $user = Auth::user();
        // Get the currently authenticated user's ID...
        $id = Auth::id();

        return Caja::where('estado', 'Abierta')
                ->where('user_id','=' ,$id)
               ->orderBy('id', 'desc')
               ->first();
        // return Sessioncaja::find($session_caja_id);
    }
}
