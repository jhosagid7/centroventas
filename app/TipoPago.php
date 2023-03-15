<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $fillabel = [
        'nombre',
        'descripcion',
        'categoria_pago_id'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];



    public function categoria_pago(){
        return $this->belongsTo(CategoriaPago::class);
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function scopeName($query, $name){
        if($name)
        return $query->where('articulos.nombre', 'LIKE', "%$name%");
    }

    public function scopeCodigo($query, $codigo){
        if($codigo)
        return $query->where('articulos.codigo', 'LIKE', "%$codigo%");
    }

    public function scopeVenderaL($query, $venderal){
        if($venderal)
        return $query->where('articulos.vender_al', 'LIKE', "$venderal");
    }
    public function scopeMayor($query){

        return $query->where('vender_al', '=', "Mayor");
    }
    public function scopeCategoria_id($query,$cat_id){

        return $query->where('categoria_pago_id', '=', "$cat_id");
    }
    public function scopeDetal($query){

        return $query->where('vender_al', '=', "Detal");
    }

    public function scopeActivo($query){

        return $query->where('estado', '=', "Activo");
    }

    public function scopeInactivo($query){

        return $query->where('estado', '=', "Inactivo");
    }

    public function scopeFecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('articulos.created_at', [$fecha_inicio, $fecha_fin]);
        }
    }

    public function setporEspecialAttribute($value){
        $this->attributes['porEspecial'] = ($value == '' ? null : $value);
    }

    public function setIsDolarAttribute($value){
        $this->attributes['isDolar'] = ($value == 'on' ? '1' : null);
    }

    public function setIsPesoAttribute($value){
        $this->attributes['isPeso'] = ($value == 'on' ? '1' : null);
    }

    public function setIsTransPuntoAttribute($value){
        $this->attributes['isTransPunto'] = ($value == 'on' ? '1' : null);
    }

    public function setIsMixtoAttribute($value){
        $this->attributes['isMixto'] = ($value == 'on' ? '1' : null);
    }

    public function setIsEfectivoAttribute($value){
        $this->attributes['isEfectivo'] = ($value == 'on' ? '1' : null);
    }

    public function setIsKiloAttribute($value){
        $this->attributes['isKilo'] = ($value == 'on' ? '1' : null);
    }
}
