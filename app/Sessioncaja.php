<?php

namespace App;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Sessioncaja extends Model
{
    public $timestamps = true;
    protected $fillabel = [

        'estado'
    ];

    protected $guarded = [];

    //creamos un metodo no estatico para llamarlo como un objeto y poder
    // llamarlo desde cualquier lado no dentro de la clase como lo static function
    public function totalVentas(){
        // return $this->id;
    }

    public static function crearsession(){
        $session_caja_id = \Session::get('session_caja_id');
        if (isset($session_caja_id)) {
            $session_caja_id = \Session::get('session_caja_id');
            $session_caja = Sessioncaja::buscarOrCrearIDSession(null);
            \Session::put('session_caja_id', $session_caja->id);
        }else {
            $session_caja_id = \Session::get('session_caja_id');
            $session_caja = Sessioncaja::buscarOrCrearIDSession($session_caja_id);
            \Session::put('session_caja', $session_caja);
        }
    }

    //Creamos un metodo integrador
    public static function buscarOrCrearIDSession($session_caja_id) {


        if ($session_caja_id) {
            //si existe Buscamos el id de la session_caja
            return Sessioncaja::buscarPorSession($session_caja_id);
        }else {
                //si no existe
            if (Sessioncaja::buscarCajaAbierta()) {
                // dd(SessionCaja::buscarCajaAbierta());
               return Sessioncaja::buscarCajaAbierta();
            }else {
               //si no existe Bamos a crear un session_caja_id
            return Sessioncaja::crearSinSession();
            }

        }
    }

    //ahora creamos un metodo para que nos realice las acciones correspondientes
        //los metodos deben hacer una sola cosa

    //este metodo nos ba a buscar la session_caja id
    public static function buscarPorSession($session_caja_id) {
        return Sessioncaja::find($session_caja_id);
    }

    //este metodo nos ba a buscar la session_caja id
    public static function buscarCajaAbierta() {
        return Sessioncaja::where('estado', 'Abierta')
               ->orderBy('id', 'desc')
               ->first();
        // return Sessioncaja::find($session_caja_id);
    }



    //este metodo nos permite dar formato al numero de la factura
    public static function numCodigo($sucursal, $op, $id_cod) {
        if (empty($sucursal) || empty($op) || empty($id_cod)) {
            throw new Exception('!La funcion numCodigo esperaba 3 parametros y uno no fue dado...');
            exit;
        } else {
            $longitud       = strlen($id_cod);
            $resta          = '-' . $longitud;
            $resul_num      = substr_replace('00000000', $id_cod, $resta);
            $num_Codigo     = strtoupper($sucursal . $op . $resul_num);
            // $num_Codigo     = strtoupper($sucursal . '-' . $op . $resul_num);
            return $num_Codigo;
        }
    }

    //fin de metodo numCodigo
    //######################################################################
    //este metodo nos permite dar formato al numero de la factura
    public static function numCodigoFactura($id_cod) {
        if (empty($id_cod)) {
            throw new Exception('!La funcion numero de factura esperaba 1 parametro...');
            exit;
        } else {
            $longitud   = strlen($id_cod);
            $resta      = '-' . $longitud;
            $resul_num  = substr_replace('00000000', $id_cod, $resta);
            $num_Codigo = strtoupper($resul_num);
            return $num_Codigo;
        }
    }

    //fin de metodo numCodigoFactura

    public static function formatoAmericano($valor) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = (float) $valor;
        return $valor;
    }

    public static function fechaNormal($fecha) {
        $nfecha = date('d/m/Y', strtotime($fecha));
        return $nfecha;
    }

    public static function formatoLatino($valor) {
        $valor = number_format($valor, $decimals = 2, $dec_point = ",", $thousands_sep = ".");

        return $valor;
    }

    //ahora creamos el metodo para crear la session caja SessionCaja::numCodigo('1', $op, $id_cod)
    public static function crearSinSession(){



        return SessionCaja::create([
            'estado' => 'Abierta'
        ]);
    }
}
