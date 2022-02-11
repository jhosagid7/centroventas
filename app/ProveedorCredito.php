<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorCredito extends Model
{
    protected $fillabel = [
        'nombre_cliente',
        'cedula_cliente',
        'direccion_cliente',
        'telefono_cliente',
        'total_factura',
        'total_deuda',
        'fecha_limite_pago',
        'estado_credito',
        'persona_id',
        'user_id'
    ];


    protected $guarded = [];

    protected $dates = [
        'fecha_limite_pago',
    ];



    public function Persona(){
        return $this->belongsTo(Persona::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function credito_ingreso(){
        return $this->hasMany(CreditoIngreso::class);
    }
}
