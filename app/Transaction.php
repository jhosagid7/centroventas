<?php

namespace App;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillabel = [
        'tipo_operacion',
        'tipo_descargo',
        'deposito',
        'num_documento',
        'user_id',
        'autarizado_por',
        'proposito',
        'detalle',
        'total_operacion',
        'estado'
    ];


    protected $guarded = [];

    public function articulo_transactions(){
        return $this->hasMany(Articulo_transactions::class);
    }

    public function articulos()
    {
        return $this->hasManyThrough(Articulo::class, Articulo_transactions::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFecha($query, $fecha){

        if($fecha){
            list($fecha_inicio, $fecha_fin) = explode(" - ", $fecha);
                $fecha_inicio = Carbon::parse($fecha_inicio. '00:00:00')->format('Y-m-d H:i:s');
                $fecha_fin = Carbon::parse($fecha_fin. '23:59:59')->format('Y-m-d H:i:s');
            return $query->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
        }
    }

    public function scopeOperador($query, $operador){
        if($operador)
        return $query->where('user_id', 'LIKE', "%$operador%");
    }

    public function scopeEstado($query, $estado){
        if($estado)
        return $query->where('estado', 'LIKE', "$estado");
    }

    //este metodo nos permite dar formato al numero de la factura
    public static function numCodigo($proseso, $op, $id_cod) {
        if (empty($proseso) || empty($op) || empty($id_cod)) {
            throw new Exception('!La funcion numCodigo esperaba 3 parametros y uno no fue dado...');
            exit;
        } else {
            $longitud       = strlen($id_cod);
            $resta          = '-' . $longitud;
            $resul_num      = substr_replace('00000000', $id_cod, $resta);
            $num_Codigo     = strtoupper($proseso . $op . $resul_num);
            // $num_Codigo     = strtoupper($sucursal . '-' . $op . $resul_num);
            return $num_Codigo;
        }
    }
}
