<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //Hacemos referencia a que talla se refiere este modelo
    // protected $table        = 'categoria';

    //Decalaramos que atributo va a ser la clave primaria de la tabla
    // protected $primaryKey   = 'idcategoria';

    //Para que laravel no nos cree dos columnas en la tabla como cuando se creo y cuando se actualizo
    //debemos especificar el parametro false de lo contrario se coloca true
    //protected $timestamps   = false;
    // public $timestamps = false;

    //Haora debemos especificar cuales son los atributos que deben recibir un valor para almacenar en nuestra tabla
    protected $fillabel     = [
        'nombre',
        'descripcion',
        'condicion'
    ];

    //Haora especificamos los campos guarded
    protected $guarded=[

    ];

    public function articulos(){
        return $this->hasMany(Articulo::class);
    }

    public function scopeNombre($query, $nombre){
        if($nombre)
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }

    public function scopeDescription($query, $description){
        if($description)
        return $query->where('descripcion', 'LIKE', "%$description%");
    }

    public function scopeCondition($query, $condition){
        if($condition)
        return $query->where('condicion', 'LIKE', "$condition");
    }

    public function scopeFecha($query, $fecha){

        if($fecha){
        list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
            $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
        return $query->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
        }
    }
}
