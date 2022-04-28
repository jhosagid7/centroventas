<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteCredito extends Model
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

    public function Persona(){
        return $this->belongsTo(Persona::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
