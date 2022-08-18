<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use Response;

class DatatableController extends Controller
{
    public function ventas(){
        $ventas = Venta::select('id','fecha_hora','persona_id', 'serie_comprobante', 'total_venta', 'estado')->get();
        // return $ventas;
        // return json_encode($ventas);
        // return response()->json($ventas);
        // $venta = Response::json(['data' => $ventas], 200);
        // return datatables($ventas)->toJson();
        return datatables()->of($ventas)->toJson();
    }
}
