<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tasa;
use App\Venta;
use App\Articulo;
use Carbon\Carbon;
use App\Sessioncaja;
use App\Transaccion;
use App\Contabilidad;
use App\ControlStock;
use App\Denominacion;
use App\ClienteCredito;
use App\SaldosMovimiento;
use Illuminate\Http\Request;
use App\HistorialCreditoCaja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CajaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Sessioncaja::crearsession();
        $cajas = Caja::get();
        $denominacion_dolar = Denominacion::where('moneda', 'Dolar')->orderBy('id', 'desc')->get();
        $denominacion_peso = Denominacion::where('moneda', 'Pesos')->orderBy('id', 'desc')->get();
        $denominacion_bolivar = Denominacion::where('moneda', 'Bolivares')->orderBy('id', 'desc')->get();
        $cajaSessionid =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();
        // dd($cajaSessionid);
        $Caja = Caja::where("estado","=",'Abierta')->where("sessioncaja_id","=", $cajaSessionid->id)->first();
        // dd($Caja);
        if (is_null($Caja)) {
            $mostrarNuvaVenta = 1;
        } else {
            $mostrarNuvaVenta = 0;
        }

        // este codigo maneja las fechas de los creditos vencidos
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


            $creditos_vencidos = Venta::where('tipo_pago_condicion', 'Credito')->where('status', 'Pendiente')->get();
            // return $creditos_vencidos;
            $creditos_clientes = ClienteCredito::get();
            if ($creditos_vencidos) {


            foreach ($creditos_vencidos as $credVencido) {
                $date = Carbon::now('America/Caracas');
                $now = Carbon::parse($date);
                $second = $credVencido->created_at;
                $addFecha = $second->addDay($credVencido->Persona->limite_fecha);
                // return $now . ' '. $second . ' ' . $addFecha . ' - ' . $credVencido->created_at;

                if ($now->gte($addFecha)) {
                    // return 'tiene credito vencido';
                    $credito_id = $credVencido->id;
                    $upCredito = Venta::findOrFail($credito_id);

                    $upCredito->estado_credito = 'Vencido';
                    $upCredito->update();

                    $cliente_moroso = ClienteCredito::where('persona_id', $credVencido->persona_id)->first();

                    if ($cliente_moroso->total_deuda > 0) {
                        $cliente_moroso->estado_credito = 'Moroso';
                        $cliente_moroso->update();
                    }else{
                        $cliente_moroso->estado_credito = 'Activo';
                        $cliente_moroso->update();
                    }

                }else{
                    // return 'no tiene credito vencido';
                }

            }
        }





    // return $cajas;
    return view('cajas.caja.index', compact('mostrarNuvaVenta','cajas', 'denominacion_dolar', 'denominacion_peso', 'denominacion_bolivar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Crear caja';
        $caja =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();
        // dd($caja);
        // $verificar_caja =  Caja::where('sessioncaja_id',$caja->id )->orderBy('id', 'desc')->first();
        $denominacion_dolar = Denominacion::where('moneda', 'Dolar')->orderBy('id', 'desc')->get();
        $denominacion_peso = Denominacion::where('moneda', 'Pesos')->orderBy('id', 'desc')->get();
        $denominacion_bolivar = Denominacion::where('moneda', 'Bolivares')->orderBy('id', 'desc')->get();

        return view('cajas.caja.create', compact('caja','title','denominacion_dolar','denominacion_peso','denominacion_bolivar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        try{
            DB::beginTransaction();
            $date              = Carbon::now('America/Caracas');
            $fecha             = $date->format('d-m-Y');
            $year              = $date->format('Y');
            $mes               = $date->format('m');
            $hora              = $date->format('h:i:s A');
            $idUsuario         = $request->get('idusuario');
            $session_id        = $request->get('session_id');
            $estatus_caja      = 'Apertura';

            $tasaVentaEfectivo = Tasa::where('nombre', 'efectivoVenta')->first();
            $tasaDolarOpen = Tasa::where('nombre', 'Dolar')->first();
            $tasaPesoOpen = Tasa::where('nombre', 'Peso')->first();
            $tasaTransferenciaPuntoOpen = Tasa::where('nombre', 'Transferencia_Punto')->first();
            $tasaEfectivoOpen = Tasa::where('nombre', 'Efectivo')->first();




                $Caja = new Caja;
                $Caja->codigo                                               = '';
                $Caja->fecha                                                = $fecha;
                $Caja->hora_cierre                                          = 'Sin cerrar';
                $Caja->hora                                                 = $hora;
                $Caja->mes                                                  = $mes;
                $Caja->year                                                 = $year;
                $Caja->monto_dolar                                          = $request->get('total_dolar');
                $Caja->monto_peso                                           = $request->get('total_peso');
                $Caja->monto_bolivar                                        = $request->get('total_bolivar');
                $Caja->monto_dolar_cierre                                   = 0.00;
                $Caja->monto_peso_cierre                                    = 0.00;
                $Caja->monto_bolivar_cierre                                 = 0.00;
                $Caja->estado                                               = 'Abierta';
                $Caja->caja                                                 = $request->get('caja');
                $Caja->tasaDolarOpen                                        = $tasaDolarOpen->tasa;
                $Caja->tasaDolarOpenPorcentajeGanancia                      = $tasaDolarOpen->porcentaje_ganancia;
                $Caja->tasaPesoOpen                                         = $tasaPesoOpen->tasa;
                $Caja->tasaPesoOpenPorcentajeGanancia                       = $tasaPesoOpen->porcentaje_ganancia;
                $Caja->tasaTransferenciaPuntoOpen                           = $tasaTransferenciaPuntoOpen->tasa;
                $Caja->tasaTransferenciaPuntoOpenPorcentajeGanancia         = $tasaTransferenciaPuntoOpen->porcentaje_ganancia;
                $Caja->tasaEfectivoOpen                                     = $tasaEfectivoOpen->tasa;
                $Caja->tasaEfectivoOpenPorcentajeGanancia                   = $tasaEfectivoOpen->porcentaje_ganancia;
                $Caja->tasaActualVenta                                      = $tasaVentaEfectivo->tasa;
                $Caja->margenActualVenta                                    = $tasaVentaEfectivo->porcentaje_ganancia;
                $Caja->user_id                                              =  $idUsuario;
                $Caja->sucursal_id                                          = 1;
                $Caja->sessioncaja_id                                       = $request->get('session_id');
                $Caja->save();

                $codigo = Sessioncaja::numCodigo('CA', $idUsuario, $Caja->id);

                $CajaUp = Caja::find($Caja->id)->where("estado", 'Abierta')
                ->update(["codigo" => $codigo]);








            $UserName = $request->user();

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //when we open the box we inital the stock

                $stocks = self::get_product_stock(['id','stock','nombre']);

                if($stocks){
                    foreach ($stocks as $value) {
                        $control_stock = new ControlStock();
                        $control_stock->stock_inicio = $value->stock;
                        $control_stock->user_id  = $idUsuario;
                        $control_stock->articulo_id  = $value->id;
                        $control_stock->caja_id  = $Caja->id;
                        $control_stock->save();
                    }

                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }
        $caja =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();
        // dd($caja);
        $verificar_caja =  Caja::where('sessioncaja_id',$caja->id )->orderBy('id', 'desc')->first();
        $mensaje = $UserName->name.'  La Caja fué Abierta exitosamente. ¡Que tengas una hermosa jornada!';
        // $mostrar = self::show($verificar_caja->id,$mensaje);
        // return $mostrar;
        return redirect()
        ->route('caja.show',$verificar_caja->id)
        ->with('status_success',  $UserName->name.'  La Caja fué Abierta exitosamente. ¡Que tengas una exitosa jornada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $mensaje = '')
    {
        // return 'hola desde show  id'.$id.' '.$mensaje;
        // return $request;
        $title = 'Resumen de Caja';
        $caja = Caja::find($id);
        $denominacion_dolar = Denominacion::where('moneda', 'Dolar')->orderBy('id', 'desc')->get();
        $denominacion_peso = Denominacion::where('moneda', 'Pesos')->orderBy('id', 'desc')->get();
        $denominacion_bolivar = Denominacion::where('moneda', 'Bolivares')->orderBy('id', 'desc')->get();
        // $tasa_efectivoVenta = Tasa::where('nombre', 'efectivoVenta')->first();
        // return $cajas;

        $tasaDolar = DB::table('tasas')->where('nombre', '=', 'Dolar')->first();
        $tasaPeso = DB::table('tasas')->where('nombre', '=', 'Peso')->first();
        $tasaTransferenciaPunto = DB::table('tasas')->where('nombre', '=', 'Transferencia_Punto')->first();
        $tasaMixto = DB::table('tasas')->where('nombre', '=', 'Mixto')->first();
        $tasaEfectivo = DB::table('tasas')->where('nombre', '=', 'Efectivo')->first();

        // $sumaDivisa = Venta::find(6);
        // $sumaDivisa->pago_ventas;
        // $sumaDivisa->caja->user;

        $cajas = Caja::find($caja->id);
                $cajas->user;
                $cajas->ventas;
                // $cajas->ventas->personas;
                $cajas->pago_ventas;
                $cajas->articulo_ventas;
                $cajas->pago_creditos;
                $cajas->detalle_credito_ventas;
                // $cajas->articulo_ventas->articulo;

        // $v = Venta::find(6);
        // $v->caja;
        // $v->pago_ventas;
        // $v->caja->user;
        // $v->persona;

         //dd($cajas->ventas);
                // $cont = 0;
                // while ($cont < count($cajas->pago_ventas)) {
                //     $v1[] = $cajas->pago_ventas[$cont]->Divisa;
                //     $cont = $cont+1;
                // }

                foreach ($cajas->pago_ventas as $pago ) {

                    if ($pago->Divisa == 'Dolar') {
                        $cajas->SumaTotalDolar = $cajas->SumaTotalDolar + $pago->MontoDivisa;
                        $cajas->SumaTotalDolarDolar = $cajas->SumaTotalDolarDolar + $pago->MontoDolar;
                        }elseif ($pago->Divisa == 'Peso') {
                        $cajas->SumaTotalPeso = $cajas->SumaTotalPeso + $pago->MontoDivisa;
                        $cajas->SumaTotalPesoDolar = $cajas->SumaTotalPesoDolar + $pago->MontoDolar;
                        }elseif ($pago->Divisa == 'Bolivar') {
                        $cajas->SumaTotalBolivar = $cajas->SumaTotalBolivar + $pago->MontoDivisa;
                        $cajas->SumaTotalBolivarDolar = $cajas->SumaTotalBolivarDolar + $pago->MontoDolar;
                        }elseif ($pago->Divisa == 'Punto') {
                        $cajas->SumaTotalPunto = $cajas->SumaTotalPunto + $pago->MontoDivisa;
                        $cajas->SumaTotalPuntoDolar = $cajas->SumaTotalPuntoDolar + $pago->MontoDolar;
                        }elseif ($pago->Divisa == 'Transferencia') {
                        $cajas->SumaTotalTransferencia = $cajas->SumaTotalTransferencia + $pago->MontoDivisa;
                        $cajas->SumaTotalTransferenciaDolar = $cajas->SumaTotalTransferenciaDolar + $pago->MontoDolar;
                    }

                }

                foreach ($cajas->ventas as $vent ) {
                    if ($vent->estado == 'Aceptada' && $vent->tipo_pago_condicion == 'Contado') {
                    $cajas->SumaTotalVentas = $cajas->SumaTotalVentas + $vent->total_venta;
                    $cajas->SumaTotalCostoVentas = $cajas->SumaTotalCostoVentas + $vent->precio_costo;
                    $cajas->SumaTotalMargenVentas = $cajas->SumaTotalMargenVentas + $vent->margen_ganancia;
                    $cajas->SumaTotalUtilidadVentas = $cajas->SumaTotalUtilidadVentas + $vent->ganancia_neta;
                    $cajas->SumaTotalCantidadVentas = $cajas->SumaTotalCantidadVentas + 1;
                    }
                }
                $nombre = [];
                foreach ($cajas->articulo_ventas as $art_vent ) {
                    $nombre[] = Articulo::find($art_vent->articulo_id);
                    $cajas->nombreArticulos = $nombre;
                    if ($art_vent->venta->estado == 'Aceptada') {
                        $cajas->SumaArticulosVendidos = $cajas->SumaArticulosVendidos + $art_vent->cantidad;
                    }
                }

                /////////////////////////////////////////////
                foreach ($cajas->pago_creditos as $pagoCredito ) {

                    if ($pagoCredito->Divisa == 'Dolar') {
                        $cajas->SumaTotalDolarCredito = $cajas->SumaTotalDolarCredito + $pagoCredito->MontoDivisa;
                        $cajas->SumaTotalDolarDolarCredito = $cajas->SumaTotalDolarDolarCredito + $pagoCredito->MontoDolar;
                    }elseif ($pagoCredito->Divisa == 'Peso') {
                        $cajas->SumaTotalPesoCredito = $cajas->SumaTotalPesoCredito + $pagoCredito->MontoDivisa;
                        $cajas->SumaTotalPesoDolarCredito = $cajas->SumaTotalPesoDolarCredito + $pagoCredito->MontoDolar;
                    }elseif ($pagoCredito->Divisa == 'Bolivar') {
                        $cajas->SumaTotalBolivarCredito = $cajas->SumaTotalBolivarCredito + $pagoCredito->MontoDivisa;
                        $cajas->SumaTotalBolivarDolarCredito = $cajas->SumaTotalBolivarDolarCredito + $pagoCredito->MontoDolar;
                    }elseif ($pagoCredito->Divisa == 'Punto') {
                        $cajas->SumaTotalPuntoCredito = $cajas->SumaTotalPuntoCredito + $pagoCredito->MontoDivisa;
                        $cajas->SumaTotalPuntoDolarCredito = $cajas->SumaTotalPuntoDolarCredito + $pagoCredito->MontoDolar;
                    }elseif ($pagoCredito->Divisa == 'Transferencia') {
                        $cajas->SumaTotalTransferenciaCredito = $cajas->SumaTotalTransferenciaCredito + $pagoCredito->MontoDivisa;
                        $cajas->SumaTotalTransferenciaDolarCredito = $cajas->SumaTotalTransferenciaDolarCredito + $pagoCredito->MontoDolar;
                    }
                    $cajas->SumaTotalCreditosPagados = $cajas->SumaTotalCreditosPagados + $pagoCredito->MontoDolar;

                }

                // $creditoPagadosCaja = []; //  return $cajas->pago_creditos[1]->venta->articulo_ventas;

                $allCreditosPagados = Venta::where('caja_id',$cajas->id)->where('estado','Aceptada')->where('tipo_pago_condicion','Credito')->where('status','Pagado')->get();
                //  return $cajas->pago_creditos[1]->venta->articulo_ventas;
                foreach ($cajas->ventas as $ventCredito ) {
                    if ($ventCredito->estado == 'Aceptada' && $ventCredito->tipo_pago_condicion == 'Credito' && $ventCredito->status == 'Pagado') {
                    $cajas->SumaTotalVentasCreditoPagados = $cajas->SumaTotalVentasCreditoPagados + $ventCredito->total_venta;
                    $cajas->SumaTotalCostoVentasCreditoPagados = $cajas->SumaTotalCostoVentasCreditoPagados + $ventCredito->precio_costo;
                    $cajas->SumaTotalMargenVentasCreditoPagados = $cajas->SumaTotalMargenVentasCreditoPagados + $ventCredito->margen_ganancia;
                    $cajas->SumaTotalUtilidadVentasCreditoPagados = $cajas->SumaTotalUtilidadVentasCreditoPagados + $ventCredito->ganancia_neta;

                    }
                }
                $nombreCredito = [];
                foreach ($cajas->articulo_ventas as $art_vent_credito ) {
                    if ($art_vent_credito->venta->estado == 'Aceptada' && $art_vent_credito->venta->tipo_pago_condicion == 'Credito') {
                        $nombreCredito[] = Articulo::find($art_vent_credito->articulo_id);
                        $cajas->nombreArticulosCredito = $nombreCredito;
                        $cajas->SumaArticulosVendidosCredito = $cajas->SumaArticulosVendidosCredito + $art_vent_credito->cantidad;
                    }
                }

                foreach ($cajas->ventas as $ventCredito ) {
                    if ($ventCredito->estado == 'Aceptada' && $ventCredito->tipo_pago_condicion == 'Credito') {
                    $cajas->SumaTotalVentasCredito = $cajas->SumaTotalVentasCredito + $ventCredito->total_venta;
                    $cajas->SumaTotalCostoVentasCredito = $cajas->SumaTotalCostoVentasCredito + $ventCredito->precio_costo;
                    $cajas->SumaTotalMargenVentasCredito = $cajas->SumaTotalMargenVentasCredito + $ventCredito->margen_ganancia;
                    $cajas->SumaTotalUtilidadVentasCredito = $cajas->SumaTotalUtilidadVentasCredito + $ventCredito->ganancia_neta;
                    $cajas->SumaTotalCantidadVentasCredito = $cajas->SumaTotalCantidadVentasCredito + 1;
                    }
                }

                //GESTIONAR DETALLE CREDITOS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($cajas->estado == 'Cerrada') {

                $historialCreditosCaja = HistorialCreditoCaja::where('caja_id', $id)->first();
                if($historialCreditosCaja){
                    // return $historialCreditosCaja;
                    $cajas->SumaTotalCantidadCreditosVigentes = $historialCreditosCaja->hist_creditos_vigentes;
                    $cajas->SumaTotalCantidadCreditosVencidos = $historialCreditosCaja->hist_creditos_vencidos;
                    $cajas->SumaTotalCantidadVentasCreditoPagados = $historialCreditosCaja->hist_creditos_pagados;
                    $cajas->hist_creditos_nuevos = $historialCreditosCaja->hist_creditos_nuevos;
                    $cajas->hist_total_creditos = $historialCreditosCaja->hist_total_creditos;
                }

            }else{
                $g = 0;
                foreach ($cajas->pago_creditos as $value) {
                    // return $value;
                    $g ++;

                    $cajas->SumaTotalCantidadVentasCreditoPagados = $cajas->SumaTotalCantidadVentasCreditoPagados + 1;
                }
                // return $g;
                $cajas->SumaTotalCantidadCreditosVigentes = Venta::where('estado_credito','Vigente')->count();
                $cajas->SumaTotalCantidadCreditosVencidos = Venta::where('estado_credito','Vencido')->count();
            }




            $creditos_vencidos = Venta::where('tipo_pago_condicion', 'Credito')->where('status', 'Pendiente')->get();
            // return $creditos_vencidos;
            $creditos_clientes = ClienteCredito::get();
            if ($creditos_vencidos) {


            foreach ($creditos_vencidos as $credVencido) {
                $date = Carbon::now('America/Caracas');
                $now = Carbon::parse($date);
                $second = $credVencido->created_at;
                $addFecha = $second->addDay($credVencido->Persona->limite_fecha);
                // return $now . ' '. $second . ' ' . $addFecha . ' - ' . $credVencido->created_at;

                if ($now->gte($addFecha)) {
                    // return 'tiene credito vencido';
                    $credito_id = $credVencido->id;
                    $upCredito = Venta::findOrFail($credito_id);

                    $upCredito->estado_credito = 'Vencido';
                    $upCredito->update();

                    $cliente_moroso = ClienteCredito::where('persona_id', $credVencido->persona_id)->first();

                    if ($cliente_moroso->total_deuda > 0) {
                        $cliente_moroso->estado_credito = 'Moroso';
                        $cliente_moroso->update();
                    }else{
                        $cliente_moroso->estado_credito = 'Activo';
                        $cliente_moroso->update();
                    }

                }else{
                    // return 'no tiene credito vencido';
                }

            }
        }


                //  return $cajas->pago_creditos[1]->venta->articulo_ventas;
        return view('cajas.caja.show', compact('title','cajas', 'caja','denominacion_dolar', 'denominacion_peso' ,'denominacion_bolivar','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaMixto','tasaEfectivo'))->with($mensaje);
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
        // return $request;
        try{
            DB::beginTransaction();
            $date   = Carbon::now('America/Caracas');
            $fecha  = $date->format('d-m-Y');
            $year   = $date->format('Y');
            $mes    = $date->format('m');
            $hora   = $date->format('h:i:s A');
            $idUsuario = $request->get('idusuario');
            $estatus_caja = 'Cierre';
            $session_id = $request->get('session_id');
            $caja_id = $request->get('caja_id');

            $monto_dolar_cierre       = $request->get('total_dolar');
            $monto_peso_cierre        = $request->get('total_peso');
            $monto_bolivar_cierre     = $request->get('total_bolivar');
            $monto_punto_cierre       = $request->get('total_punto');
            $monto_trans_cierre       = $request->get('total_trans');

            $tasaDolarClose = Tasa::where('nombre', 'Dolar')->first();
            $tasaPesoClose = Tasa::where('nombre', 'Peso')->first();
            $tasaTransferenciaPuntoClose = Tasa::where('nombre', 'Transferencia_Punto')->first();
            $tasaEfectivoClose = Tasa::where('nombre', 'Efectivo')->first();





                //TODO INSERTAR REGISTROS EN LA TABLA CAJA

                $Caja = Caja::findOrFail($caja_id);
                $Caja->hora_cierre              = $hora;
                $Caja->monto_dolar_cierre       = $monto_dolar_cierre;
                $Caja->monto_peso_cierre        = $monto_peso_cierre;
                $Caja->monto_bolivar_cierre     = $monto_bolivar_cierre;
                $Caja->monto_punto_cierre       = $monto_punto_cierre;
                $Caja->monto_trans_cierre       = $monto_trans_cierre;
                $Caja->tasaDolarClose                                    = $tasaDolarClose->tasa;
                $Caja->tasaDolarClosePorcentajeGanancia                  = $tasaDolarClose->porcentaje_ganancia;
                $Caja->tasaPesoClose                                     = $tasaPesoClose->tasa;
                $Caja->tasaPesoClosePorcentajeGanancia                   = $tasaPesoClose->porcentaje_ganancia;
                $Caja->tasaTransferenciaPuntoClose                       = $tasaTransferenciaPuntoClose->tasa;
                $Caja->tasaTransferenciaPuntoClosePorcentajeGanancia     = $tasaTransferenciaPuntoClose->porcentaje_ganancia;
                $Caja->tasaEfectivoClose                                 = $tasaEfectivoClose->tasa;
                $Caja->tasaEfectivoClosePorcentajeGanancia               = $tasaEfectivoClose->porcentaje_ganancia;
                $Caja->monto_dolar_cierre_dif   = $request->get('total_dolar_dif');
                $Caja->monto_peso_cierre_dif    = $request->get('total_peso_dif');
                $Caja->monto_bolivar_cierre_dif = $request->get('total_bolivar_dif');
                $Caja->monto_punto_cierre_dif   = $request->get('total_punto_dif');
                $Caja->monto_trans_cierre_dif   = $request->get('total_trans_dif');
                $Caja->dolar_dolar_operador     = $request->get('dif_moneda_dolar_to_dolar_input');
                $Caja->peso_dolar_operador      = $request->get('dif_moneda_peso_to_dolar_input');
                $Caja->punto_dolar_operador     = $request->get('dif_moneda_punto_to_dolar_input');
                $Caja->trans_dolar_operador     = $request->get('dif_moneda_trans_to_dolar_input');
                $Caja->efectivo_dolar_operador  = $request->get('dif_moneda_efectivo_to_dolar_input');
                $Caja->dolar_sistema            = $request->get('dolar_sistema');
                $Caja->peso_sistema             = $request->get('peso_sistema');
                $Caja->punto_sistema            = $request->get('punto_sistema');
                $Caja->trans_sistema            = $request->get('trans_sistema');
                $Caja->efectivo_sistema         = $request->get('efectivo_sistema');
                $Caja->total_sistema_reg        = $request->get('total_sistema_reg_input');
                $Caja->total_operador_reg       = $request->get('total_operador_reg_input');
                $Caja->total_diferencia         = $request->get('total_dif_input');
                $Caja->Observaciones            = $request->get('Observaciones');
                $Caja->estado                   = 'Cerrada';
                $Caja->update();

                $session_id = Sessioncaja::findOrFail($session_id);
                $session_id->estado = 'Cerrada';
                $session_id->update();


                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Guardamos registros en la tabla historialcreditoscaja
                //Save the data in the table historialCreditosCaja

                $historialCreditosCaja = new HistorialCreditoCaja();
                $historialCreditosCaja->hist_creditos_vigentes = $request->get('hist_creditos_vigentes');
                $historialCreditosCaja->hist_creditos_vencidos = $request->get('hist_creditos_vencidos');
                $historialCreditosCaja->hist_creditos_pagados = $request->get('hist_creditos_pagados');
                $historialCreditosCaja->hist_creditos_nuevos = $request->get('hist_creditos_nuevos');
                $historialCreditosCaja->hist_total_creditos = $request->get('hist_total_creditos');
                $historialCreditosCaja->user_id = $request->get('idusuario');
                $historialCreditosCaja->caja_id = $caja_id;
                $historialCreditosCaja->save();

                 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //when we close the box we finiched the stock

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $controlStock = ControlStock::where('caja_id', $caja_id)->get();

                if($controlStock){
                    $stocks = self::get_product_stock(['id','stock','nombre']);
                    if($stocks){
                    foreach ($stocks as $value) {
                        $control_stock = ControlStock::where('articulo_id',$value->id)->where('caja_id',$caja_id)->first();
                        if($control_stock){
                            $control_stock->stock_cierre = $value->stock;
                            $control_stock->stock_dif  = $control_stock->stock_cierre - $value->stock;
                            $control_stock->stock_cierre_operador  = $request->get('stock_cierre_operador');
                            $control_stock->observaciones  = $request->get('observacionesStock');
                            $control_stock->update();
                        }else{
                            $control_stock = new ControlStock();
                            $control_stock->stock_inicio = 0;
                            $control_stock->stock_cierre = $value->stock;
                            $control_stock->user_id  = $idUsuario;
                            $control_stock->articulo_id  = $value->id;
                            $control_stock->caja_id  = $Caja->id;
                            $control_stock->save();
                        }

                    }

                }
                }

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Sessioncaja::crearsession();

            $UserName = $request->user();
            // return $UserName;

//             if (!empty($monto_peso_cierre) && $monto_peso_cierre > 0) {
//                 return 'no'.$monto_peso_cierre;
//             }else{
//                 return 'si';
//             }
// return $UserName;

            if (!empty($monto_dolar_cierre) && $monto_dolar_cierre > 0 || !empty($monto_peso_cierre) && $monto_peso_cierre > 0 || !empty($monto_bolivar_cierre) && $monto_bolivar_cierre > 0 || !empty($monto_punto_cierre) && $monto_punto_cierre > 0 || !empty($monto_trans_cierre) && $monto_trans_cierre > 0) {





            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Guardamos los montos recibidos en caja en banco
            // Guardamos en la tabla transaccions

            //Buscamos el correlativo
            // return $monto_dolar_cierre.' '.$monto_peso_cierre.' '.$monto_bolivar_cierre.' '.$monto_punto_cierre.' '.$monto_trans_cierre;


                $correlativo_transaccion = Transaccion::count();
                $correlativo_transaccion = $correlativo_transaccion + 1;

                $transaccion = new Transaccion();
                $transaccion->correlativo    = $correlativo_transaccion;
                $transaccion->descripcion_op = 'Por el cobro en caja';
                $transaccion->codigo         = $caja_id;
                $transaccion->denominacion   = 'Monto enviado por el operador de la caja';
                $transaccion->operador       = $UserName->name;
                $transaccion->save();

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Consultamos en que monedas nos estan pagado y las guardamos

                if (!empty($monto_dolar_cierre) && $monto_dolar_cierre > 0) {
                    $correlativo_dolar = SaldosMovimiento::where('cuenta_id', 1)->count();
                    $correlativo_dolar = $correlativo_dolar + 1;
                    $saldo_dolar = SaldosMovimiento::where('cuenta_id', 1)->latest('id')->first();
                    if($saldo_dolar){
                        $saldo_dolar = $saldo_dolar->saldo;
                    }else{
                        $saldo_dolar = 0;
                    }
                    // Guardamos los montos recibidos en caja en banco
                    $saldos_movimientos = new SaldosMovimiento();
                    $saldos_movimientos->correlativo    = $correlativo_dolar;
                    $saldos_movimientos->debe           = $monto_dolar_cierre;
                    $saldos_movimientos->haber          = 0;
                    $saldos_movimientos->saldo          = $saldo_dolar + $monto_dolar_cierre;
                    $saldos_movimientos->cuenta_id      = 1;
                    $saldos_movimientos->transaccion_id = $transaccion->id;
                    $saldos_movimientos->save();
                }

                if (!empty($monto_peso_cierre) && $monto_peso_cierre > 0) {
                    $correlativo_peso = SaldosMovimiento::where('cuenta_id', 2)->count();
                    $correlativo_peso = $correlativo_peso + 1;
                    $saldo_peso = SaldosMovimiento::where('cuenta_id', 2)->latest('id')->first();
                    if($saldo_peso){
                        $saldo_peso = $saldo_peso->saldo;
                    }else{
                        $saldo_peso = 0;
                    }

                    // return $saldo_peso->saldo;
                    // Guardamos los montos recibidos en caja en banco
                    $saldos_movimientos = new SaldosMovimiento();
                    $saldos_movimientos->correlativo    = $correlativo_peso;
                    $saldos_movimientos->debe           = $monto_peso_cierre;
                    $saldos_movimientos->haber          = 0;
                    $saldos_movimientos->saldo          = $saldo_peso + $monto_peso_cierre;
                    $saldos_movimientos->cuenta_id      = 2;
                    $saldos_movimientos->transaccion_id = $transaccion->id;
                    $saldos_movimientos->save();
                }

                if (!empty($monto_bolivar_cierre) && $monto_bolivar_cierre > 0) {
                    $correlativo_bolivar = SaldosMovimiento::where('cuenta_id', 3)->count();
                    $correlativo_bolivar = $correlativo_bolivar + 1;
                    $saldo_bolivar = SaldosMovimiento::where('cuenta_id', 3)->latest('id')->first();
                    if($saldo_bolivar){
                        $saldo_bolivar = $saldo_bolivar->saldo;
                    }else{
                        $saldo_bolivar = 0;
                    }
                    // Guardamos los montos recibidos en caja en banco
                    $saldos_movimientos = new SaldosMovimiento();
                    $saldos_movimientos->correlativo    = $correlativo_bolivar;
                    $saldos_movimientos->debe           = $monto_bolivar_cierre;
                    $saldos_movimientos->haber          = 0;
                    $saldos_movimientos->saldo          = $saldo_bolivar + $monto_bolivar_cierre;
                    $saldos_movimientos->cuenta_id      = 3;
                    $saldos_movimientos->transaccion_id = $transaccion->id;
                    $saldos_movimientos->save();
                }

                if (!empty($monto_punto_cierre) && $monto_punto_cierre > 0) {
                    $correlativo_punto = SaldosMovimiento::where('cuenta_id', 4)->count();
                    $saldo_punto = SaldosMovimiento::where('cuenta_id', 4)->latest('id')->first();
                    if($saldo_punto){
                        $saldo_punto = $saldo_punto->saldo;
                    }else{
                        $saldo_punto = 0;
                    }
                    $correlativo_punto = $correlativo_punto + 1;
                    // Guardamos los montos recibidos en caja en banco
                    $saldos_movimientos = new SaldosMovimiento();
                    $saldos_movimientos->correlativo    = $correlativo_punto;
                    $saldos_movimientos->debe           = $monto_punto_cierre;
                    $saldos_movimientos->haber          = 0;
                    $saldos_movimientos->saldo          = $saldo_punto + $monto_punto_cierre;
                    $saldos_movimientos->cuenta_id      = 4;
                    $saldos_movimientos->transaccion_id = $transaccion->id;
                    $saldos_movimientos->save();
                }

                if (!empty($monto_trans_cierre) && $monto_trans_cierre > 0) {
                    $correlativo_trans = SaldosMovimiento::where('cuenta_id', 4)->count();
                    $saldo_trans = SaldosMovimiento::where('cuenta_id', 4)->latest('id')->first();
                    if($saldo_trans){
                        $saldo_trans = $saldo_trans->saldo;
                    }else{
                        $saldo_trans = 0;
                    }
                    $correlativo_trans = $correlativo_trans + 1;
                    // Guardamos los montos recibidos en caja en banco
                    $saldos_movimientos = new SaldosMovimiento();
                    $saldos_movimientos->correlativo    = $correlativo_trans;
                    $saldos_movimientos->debe           = $monto_trans_cierre;
                    $saldos_movimientos->haber          = 0;
                    $saldos_movimientos->saldo          = $saldo_trans + $monto_trans_cierre;
                    $saldos_movimientos->cuenta_id      = 4;
                    $saldos_movimientos->transaccion_id = $transaccion->id;
                    $saldos_movimientos->save();
                }
            }



            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }

        return redirect()
        ->route('caja.index')
        ->with('status_success', $UserName->name.'La caja fue cerrada Correctamente Gracias por usar nuestro Sistema. ¡ Te Esperamos Pronto...!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return 'Estoy en destroy';
    }

    public static function get_product_stock($arg = array()){
        if(isset($arg)){
            $stock = Articulo::select($arg)->get();
            if($stock){
                return $stock;
            }else{
                return false;
            }
        }
    }
}
