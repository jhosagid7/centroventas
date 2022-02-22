<?php

namespace App;

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
        'persona_id',
        'caja_id'
    ];


    protected $guarded = [];

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
