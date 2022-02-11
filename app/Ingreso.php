<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{

    public function articulo_ingresos()
    {
        return $this->hasMany(Articulo_Ingreso::class);
    }



    public function credito_ingresos()
    {
        return $this->hasMany(CreditoIngresos::class);
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $fillabel = [
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'precio_compra',
        'fecha_hora',
        'estado',
        'tipo_pago',
        'status',
        'persona_id',
        'user_id'
    ];


    protected $guarded = [];

    protected $dates = [
        'fecha_hora',
    ];

    public function scopeFecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('ingresos.created_at', [$fecha_inicio, $fecha_fin]);
        }
    }

    public function scopeEstado($query, $estado){
        if($estado)
        return $query->where('ingresos.estado', 'LIKE', "$estado");
    }

    public function scopeOperador($query, $operador){
        if($operador)
        return $query->where('ingresos.user_id', '=', "$operador");
    }

    public function scopeProveedor($query, $proveedor){
        if($proveedor)
        return $query->where('ingresos.persona_id', '=', "$proveedor");
    }


}
// DELIMITER //
// CREATE TRIGGER tr_udpStockIngreso AFTER INSERT ON detalle_ingreso
// FOR EACH ROW BEGIN
// UPDATE articulo SET stock = stock + NEW.cantidad
// WHERE articulo.idarticulo = NEW.idarticulo;
// END
// //
// DELIMITER ;

// DELIMITER //
// CREATE TRIGGER tr_udpPrecioVentaIngreso AFTER INSERT ON detalle_ingreso
// FOR EACH ROW BEGIN
// UPDATE articulo SET precio_venta = New.precio_compra
// WHERE articulo.idarticulo = NEW.idarticulo;
// END
// //
// DELIMITER ;
