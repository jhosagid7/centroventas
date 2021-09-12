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
        'estado',
        'caja',
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

    public function pago_ventas()
    {
        return $this->hasManyThrough(Pago_Venta::class, Venta::class);
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
