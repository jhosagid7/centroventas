<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tasa;
use App\Venta;
use App\Articulo;
use Carbon\Carbon;
use App\Sessioncaja;
use App\Contabilidad;
use App\Denominacion;
use Illuminate\Http\Request;
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
            $date   = Carbon::now('America/Caracas');
            $fecha  = $date->format('d-m-Y');
            $year   = $date->format('Y');
            $mes    = $date->format('m');
            $hora   = $date->format('h:i:s A');
            $idUsuario = $request->get('idusuario');
            $session_id = $request->get('session_id');
            $estatus_caja = 'Apertura';

            $tasaVentaEfectivo = Tasa::where('nombre', 'efectivoVenta')->first();


                $Caja = new Caja;
                $Caja->codigo               = '';
                $Caja->fecha                = $fecha;
                $Caja->hora_cierre          = 'Sin cerrrar';
                $Caja->hora                 = $hora;
                $Caja->mes                  = $mes;
                $Caja->year                 = $year;
                $Caja->monto_dolar          = $request->get('total_dolar');
                $Caja->monto_peso           = $request->get('total_peso');
                $Caja->monto_bolivar        = $request->get('total_bolivar');
                $Caja->monto_dolar_cierre   = 0.00;
                $Caja->monto_peso_cierre    = 0.00;
                $Caja->monto_bolivar_cierre = 0.00;
                $Caja->estado               = 'Abierta';
                $Caja->caja                 = $request->get('caja');
                $Caja->tasaActualVenta      = $tasaVentaEfectivo->tasa;
                $Caja->margenActualVenta    = $tasaVentaEfectivo->porcentaje_ganancia;
                $Caja->user_id              =  $idUsuario;
                $Caja->sucursal_id          = 1;
                $Caja->sessioncaja_id       = $request->get('session_id');
                $Caja->save();

                $codigo = Sessioncaja::numCodigo('CA', $idUsuario, $Caja->id);

                $CajaUp = Caja::find($Caja->id)->where("estado", 'Abierta')
                ->update(["codigo" => $codigo]);






//////////////////////////////////////////////////////////////////////////////////////////////////// BsubTotald
            $bcantidadR = $request->get('bcantidad');
            $BsubTotaldR = $request->get('BsubTotald');
            $bvalorR = $request->get('bvalor');
            $btipoR = $request->get('btipo');
            $bdenominacionR = $request->get('bdenominacion');

            $BsubTotaldR = array_filter($BsubTotaldR);


            if ($BsubTotaldR) {
                foreach($BsubTotaldR as $key => $val) {

                    $bcantidad[]=$bcantidadR[$key];
                    $BsubTotald[]=$BsubTotaldR[$key];
                    $bvalor[]=$bvalorR[$key];
                    $btipo[]=$btipoR[$key];
                    $bdenominacion[]=$bdenominacionR[$key];
                }

                // dd($bcantidadR, $BsubTotaldR,$bvalorR,$btipoR,$bdenominacionR);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($BsubTotald)) {

                    $detalleBolso = new Contabilidad();
                    $detalleBolso->denominacion = $bdenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolso->valor = $bvalor[$cont];
                    $detalleBolso->cantidad = $bcantidad[$cont];
                    $detalleBolso->subtotal = $BsubTotald[$cont];
                    $detalleBolso->tipo = $btipo[$cont];
                    $detalleBolso->modo = $estatus_caja;
                    $detalleBolso->caja_id = $Caja->id;
                    $detalleBolso->save();

                    $cont = $cont+1;
                }
            }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pcantidadR = $request->get('pcantidad');
            $PsubTotaldR = $request->get('PsubTotald');
            $pvalorR = $request->get('pvalor');
            $ptipoR = $request->get('ptipo');
            $pdenominacionR = $request->get('pdenominacion');

            $PsubTotaldR = array_filter($PsubTotaldR);

            if ($PsubTotaldR) {
                foreach($PsubTotaldR as $key => $val) {

                    $pcantidad[]=$pcantidadR[$key];
                    $PsubTotald[]=$PsubTotaldR[$key];
                    $pvalor[]=$pvalorR[$key];
                    $ptipo[]=$ptipoR[$key];
                    $pdenominacion[]=$pdenominacionR[$key];
                }
                // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($PsubTotald)) {

                    $detalleBolsoP = new Contabilidad();
                    $detalleBolsoP->denominacion = $pdenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolsoP->valor = $pvalor[$cont];
                    $detalleBolsoP->cantidad = $pcantidad[$cont];
                    $detalleBolsoP->subtotal = $PsubTotald[$cont];
                    $detalleBolsoP->tipo = $ptipo[$cont];
                    $detalleBolsoP->modo = $estatus_caja;
                    $detalleBolsoP->caja_id = $Caja->id;
                    $detalleBolsoP->save();

                    $cont = $cont+1;
                }
            }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $dcantidadR = $request->get('dcantidad');
            $DsubTotaldR = $request->get('DsubTotald');
            $dvalorR = $request->get('dvalor');
            $dtipoR = $request->get('dtipo');
            $ddenominacionR = $request->get('ddenominacion');

            $DsubTotaldR = array_filter($DsubTotaldR);

            if ($DsubTotaldR) {
                foreach($DsubTotaldR as $key => $val) {

                    $dcantidad[]=$dcantidadR[$key];
                    $DsubTotald[]=$DsubTotaldR[$key];
                    $dvalor[]=$dvalorR[$key];
                    $dtipo[]=$dtipoR[$key];
                    $ddenominacion[]=$ddenominacionR[$key];
                }
                // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($DsubTotald)) {

                    $detalleBolsoD = new Contabilidad();
                    $detalleBolsoD->denominacion = $ddenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolsoD->valor = $dvalor[$cont];
                    $detalleBolsoD->cantidad = $dcantidad[$cont];
                    $detalleBolsoD->subtotal = $DsubTotald[$cont];
                    $detalleBolsoD->tipo = $dtipo[$cont];
                    $detalleBolsoD->modo = $estatus_caja;
                    $detalleBolsoD->caja_id = $Caja->id;
                    $detalleBolsoD->save();

                    $cont = $cont+1;
                }
            }

            $UserName = $request->user();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

        // $sumaDivisa = Venta::find(6);
        // $sumaDivisa->pago_ventas;
        // $sumaDivisa->caja->user;

        $cajas = Caja::find($caja->id);
                $cajas->user;
                $cajas->ventas;
                // $cajas->ventas->personas;
                $cajas->pago_ventas;
                $cajas->articulo_ventas;
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
                     }elseif ($pago->Divisa == 'Peso') {
                        $cajas->SumaTotalPeso = $cajas->SumaTotalPeso + $pago->MontoDivisa;
                     }elseif ($pago->Divisa == 'Bolivar') {
                        $cajas->SumaTotalBolivar = $cajas->SumaTotalBolivar + $pago->MontoDivisa;
                     }elseif ($pago->Divisa == 'Punto') {
                        $cajas->SumaTotalPunto = $cajas->SumaTotalPunto + $pago->MontoDivisa;
                     }elseif ($pago->Divisa == 'Transferencia') {
                        $cajas->SumaTotalTransferencia = $cajas->SumaTotalTransferencia + $pago->MontoDivisa;
                     }

                }

                foreach ($cajas->ventas as $vent ) {
                    if ($vent->estado == 'Aceptada') {
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


                //  return $cajas;
        return view('cajas.caja.show', compact('title','cajas', 'caja','denominacion_dolar', 'denominacion_peso' ,'denominacion_bolivar'))->with($mensaje);
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





                $Caja = Caja::findOrFail($caja_id);
                $Caja->hora_cierre          = $hora;
                $Caja->monto_dolar_cierre = $request->get('total_dolar');
                $Caja->monto_peso_cierre = $request->get('total_peso');
                $Caja->monto_bolivar_cierre = $request->get('total_bolivar');
                $Caja->estado = 'Cerrada';
                $Caja->update();

                $session_id = Sessioncaja::findOrFail($session_id);
                $session_id->estado = 'Cerrada';
                $session_id->update();









//////////////////////////////////////////////////////////////////////////////////////////////////// BsubTotald
            $bcantidadR = $request->get('bcantidad');
            $BsubTotaldR = $request->get('BsubTotald');
            $bvalorR = $request->get('bvalor');
            $btipoR = $request->get('btipo');
            $bdenominacionR = $request->get('bdenominacion');

            $BsubTotaldR = array_filter($BsubTotaldR);


            if ($BsubTotaldR) {
                foreach($BsubTotaldR as $key => $val) {

                    $bcantidad[]=$bcantidadR[$key];
                    $BsubTotald[]=$BsubTotaldR[$key];
                    $bvalor[]=$bvalorR[$key];
                    $btipo[]=$btipoR[$key];
                    $bdenominacion[]=$bdenominacionR[$key];
                }

                // dd($bcantidadR, $BsubTotaldR,$bvalorR,$btipoR,$bdenominacionR);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($BsubTotald)) {

                    $detalleBolso = new Contabilidad();
                    $detalleBolso->denominacion = $bdenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolso->valor = $bvalor[$cont];
                    $detalleBolso->cantidad = $bcantidad[$cont];
                    $detalleBolso->subtotal = $BsubTotald[$cont];
                    $detalleBolso->tipo = $btipo[$cont];
                    $detalleBolso->modo = $estatus_caja;
                    $detalleBolso->caja_id = $Caja->id;
                    $detalleBolso->save();

                    $cont = $cont+1;
                }
            }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pcantidadR = $request->get('pcantidad');
            $PsubTotaldR = $request->get('PsubTotald');
            $pvalorR = $request->get('pvalor');
            $ptipoR = $request->get('ptipo');
            $pdenominacionR = $request->get('pdenominacion');

            $PsubTotaldR = array_filter($PsubTotaldR);

            if ($PsubTotaldR) {
                foreach($PsubTotaldR as $key => $val) {

                    $pcantidad[]=$pcantidadR[$key];
                    $PsubTotald[]=$PsubTotaldR[$key];
                    $pvalor[]=$pvalorR[$key];
                    $ptipo[]=$ptipoR[$key];
                    $pdenominacion[]=$pdenominacionR[$key];
                }
                // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($PsubTotald)) {

                    $detalleBolsoP = new Contabilidad();
                    $detalleBolsoP->denominacion = $pdenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolsoP->valor = $pvalor[$cont];
                    $detalleBolsoP->cantidad = $pcantidad[$cont];
                    $detalleBolsoP->subtotal = $PsubTotald[$cont];
                    $detalleBolsoP->tipo = $ptipo[$cont];
                    $detalleBolsoP->modo = $estatus_caja;
                    $detalleBolsoP->caja_id = $Caja->id;
                    $detalleBolsoP->save();

                    $cont = $cont+1;
                }
            }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $dcantidadR = $request->get('dcantidad');
            $DsubTotaldR = $request->get('DsubTotald');
            $dvalorR = $request->get('dvalor');
            $dtipoR = $request->get('dtipo');
            $ddenominacionR = $request->get('ddenominacion');

            $DsubTotaldR = array_filter($DsubTotaldR);

            if ($DsubTotaldR) {
                foreach($DsubTotaldR as $key => $val) {

                    $dcantidad[]=$dcantidadR[$key];
                    $DsubTotald[]=$DsubTotaldR[$key];
                    $dvalor[]=$dvalorR[$key];
                    $dtipo[]=$dtipoR[$key];
                    $ddenominacion[]=$ddenominacionR[$key];
                }
                // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
                //creamos un contador
                $cont = 0;

                //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                while ($cont < count($DsubTotald)) {

                    $detalleBolsoD = new Contabilidad();
                    $detalleBolsoD->denominacion = $ddenominacion[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                    $detalleBolsoD->valor = $dvalor[$cont];
                    $detalleBolsoD->cantidad = $dcantidad[$cont];
                    $detalleBolsoD->subtotal = $DsubTotald[$cont];
                    $detalleBolsoD->tipo = $dtipo[$cont];
                    $detalleBolsoD->modo = $estatus_caja;
                    $detalleBolsoD->caja_id = $Caja->id;
                    $detalleBolsoD->save();

                    $cont = $cont+1;
                }
            }
            // Sessioncaja::crearsession();

            $UserName = $request->user();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
}
