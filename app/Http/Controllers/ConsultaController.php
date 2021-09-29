<?php

namespace App\Http\Controllers;

use App\Tasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function precioVenta(){

        $title = 'Consulta de precios';
        $tasa = Tasa::find(1);
        $tasa->updated_at;
        $fechaActual = Carbon::now();

        $title='Consulta de precios | Productos';

        $tasaDolar = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();
        $tasaPeso = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Peso')->first();
        $tasaTransferenciaPunto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Transferencia_Punto')->first();
        $tasaMixto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Mixto')->first();
        $tasaEfectivo = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Efectivo')->first();
        $articulos = DB::table('articulos as art')
            ->select(DB::raw('CONCAT(art.codigo, " - ", art.nombre) AS articulo'), 'art.imagen', 'art.vender_al', 'art.nombre','art.id', 'precio_costo', 'porEspecial', 'isDolar', 'isPeso', 'isTransPunto', 'isMixto', 'isEfectivo', 'isKilo', 'stock', 'art.nombre')
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->where('art.precio_costo', '>', '0')
            ->get();


        return view('ventas.venta.consulta', compact('title','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaMixto','tasaEfectivo','articulos'));

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
