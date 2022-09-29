<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
   //Hacemos referencia a que talla se refiere este modelo
    // protected $table = 'articulo';

    //Decalaramos que atributo va a ser la clave primaria de la tabla
    // protected $primaryKey = 'idarticulo';

    //Para que laravel no nos cree dos columnas en la tabla como cuando se creo y cuando se actualizo
    //debemos especificar el parametro false de lo contrario se coloca true
    //protected $timestamps   = false;
    // public $timestamps = false;

    //Haora debemos especificar cuales son los atributos que deben recibir un valor para almacenar en nuestra tabla
    protected $fillabel = [
        'categoria_id',
        'codigo',
        'nombre',
        'stock',
        'precio_costo',
        'porEspecial',
        'isDolar',
        'isPeso',
        'isTransPunto',
        'isMixto',
        'isEfectivo',
        'descripcion',
        'unidades',
        'vender_al',
        'imagen',
        'area_id',
        'estado'
    ];

    //Haora especificamos los campos guarded
    protected $guarded = [];

    public function articulo_ventas(){
        return $this->hasMany(Articulo_venta::class);
    }

    public function articulo_ingresos(){
        return $this->hasMany(Articulo_Ingreso::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function area(){
        return $this->belongsTo(Area::class);
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

        return $query->where('categoria_id', '=', "$cat_id");
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

