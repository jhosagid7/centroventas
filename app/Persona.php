<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

    public function Ventas(){
        return $this->hasMany(Venta::class);
    }

    public function proveedor_creditos(){
        return $this->hasMany(ProveedorCredito::class);
    }

    public function ingresos(){
        return $this->hasMany(Ingreso::class);
    }

    public function cliente_creditos(){
        return $this->hasMany(ClienteCredito::class);
    }



    public function user(){
        return $this->hasOneThrough(User::class,Ingreso::class);
    }

    // protected $table = 'persona';

    // protected $primaryKey = 'idpersona';

    // public $timestamps = false;

    protected $fillabel = [
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
        'isCortesia',
        'Credito',
        'limite_fecha',
        'limite_monto',
        'imagen'
    ];

    protected $guarded = [];

    public function setIsCortesiaAttribute($value){
        $this->attributes['isCortesia'] = ($value == 'on' ? '1' : null);
    }

    public function setIsCreditoAttribute($value){
        $this->attributes['isCredito'] = ($value == 'on' ? '1' : null);
    }
}
