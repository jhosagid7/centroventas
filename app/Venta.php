<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    // protected $table = 'venta';

    // protected $primaryKey = 'idventa';

    // public $timestamps = false;

    public function articulo_ventas(){
        return $this->hasMany(Articulo_venta::class);
    }
    public function pago_ventas(){
        return $this->hasMany(Pago_Venta::class);
    }

    public function pago_creditos(){
        return $this->hasMany(PagoCredito::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    public function Persona(){
        return $this->belongsTo(Persona::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pagos_credito_ventas()
    {
        return $this->hasMany(DetalleCreditoVenta::class);
    }

    // public function user()
    // {
    //     return $this->hasOneThrough(User::class, Caja::class);
    // }

    protected $dates = [
        'fecha_hora',
    ];

    protected $fillabel = [
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'tipo_pago',
        'tasaDolar',
        'porDolar',
        'tasaPeso',
        'porPeso',
        'tasaTransPunto',
        'porTransPunto',
        'tasaMixto',
        'porMixto',
        'tasaEfectivo',
        'porEfectivo',
        'num_Punto',
        'num_trans',
        'precio_costo',
        'margen_ganancia',
        'total_venta',
        'ganancia_neta',
        'estado',
        'tipo_pago_condicion',
        'status',
        'estado_credito',
        'persona_id',
        'caja_id'
    ];


    protected $guarded = [];

    public function scopeFecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('ventas.created_at', [$fecha_inicio, $fecha_fin]);
        }
    }

    public function scopeEstado($query, $estado){
        if($estado)
        return $query->where('ventas.estado_credito', 'LIKE', "$estado");
    }

    public function scopeStatus($query, $status){
        if($status)
        return $query->where('ventas.status', "$status");
    }

    public function scopeOperador($query, $operador){
        if($operador)
        return $query->where('ventas.user_id', '=', "$operador");
    }

    public function scopeProveedor($query, $proveedor){
        if($proveedor)
        return $query->where('ventas.persona_id', '=', "$proveedor");
    }

}

// DELIMITER //
// CREATE TRIGGER tr_updStockVenta AFTER INSERT ON detalle_venta
// FOR EACH ROW BEGIN
// 	UPDATE articulo SET stock = stock - NEW.cantidad
//     WHERE articulo.idarticulo = NEW.idarticulo;
// END
// //
// DELIMITER ;

// DELIMITER //
// CREATE TRIGGER tr_updStockVentas AFTER INSERT ON articulo_ventas
// FOR EACH ROW BEGIN
// 	UPDATE articulos SET stock = stock - NEW.cantidad
//     WHERE articulo.id = NEW.id;
// END
// //
// DELIMITER ;
