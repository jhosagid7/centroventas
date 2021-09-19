<?php

namespace App\Http\Controllers;

use App\Caja;

use App\Tasa;
use Response;
use App\venta;
use App\Articulo;
use Carbon\Carbon;
use App\Pago_Venta;
use App\PagoVuelto;
use App\DetallePago;
use App\Sessioncaja;
use App\DetalleVenta;

use App\Http\Requests;
//use Illuminate\Http\Response;
use App\Articulo_venta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\ExcedentesRecibidosCajaActual;
use App\Http\Requests\VentaFormRequest;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Redirect;


class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $mesActual = Carbon::now()->format('Y-m-d');
            $restaMes = Carbon::now()->subWeek(4);
            $restaMes = $restaMes->format('Y-m-d');
            $title='Ventas';
            $query = trim($request->get('buscarTexto'));
            // $ventas = DB::table('ventas as v')
            //     ->join('personas as p', 'v.persona_id', '=', 'p.id')
            //     ->join('articulo_ventas as av', 'v.id', '=', 'av.venta_id')
            //     ->join('cajas as c', 'c.sessioncaja_id', '=', 'v.caja_id')
            //     ->join('users as u', 'u.id', '=', 'c.user_id')
            //     ->select('u.name','c.user_id','v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.total_venta', 'v.estado')
            //     ->where('v.num_comprobante', 'LIKE', '%'. $query  .'%')
            //     ->orderBy('v.id', 'desc')
            //     ->groupBy('u.name','c.user_id','v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.total_venta', 'v.estado')
            //     ->get();

                $ventas = DB::table('ventas as v')
                ->join('personas as p', 'v.persona_id', '=', 'p.id')
                ->join('articulo_ventas as av', 'v.id', '=', 'av.venta_id')
                ->join('cajas as c', 'c.sessioncaja_id', '=', 'v.caja_id')
                ->join('users as u', 'u.id', '=', 'c.user_id')
                ->select('u.name','c.user_id','v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_trans', 'v.num_punto', 'v.num_comprobante', 'v.total_venta', 'v.estado')
                ->where('v.num_comprobante', 'LIKE', '%'. $query  .'%')
                ->where("v.created_at",">=",$restaMes)
                ->where("v.created_at","<=",$mesActual)
                ->orderBy('v.id', 'desc')
                ->groupBy('u.name','c.user_id','v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_trans', 'v.num_punto', 'v.num_comprobante', 'v.total_venta', 'v.estado')
                ->get();
             //dd($ventas);

             //$ventas = Venta::where('created_at', ">=", $restaMes)->where('created_at', "<=", $mesActual)->get();
            //return $ventas;
            return view('ventas.venta.index', ["title" => $title,"ventas" => $ventas, "buscarTexto" => $query]);
        }
    }

    public function create()
    {


        Sessioncaja::crearsession();
        $tasa = Tasa::find(1);
        $tasa->updated_at;
        $fechaActual = Carbon::now();
        // dd($tasa->updated_at->diffInHours($fechaActual));
        if ($tasa->tasa <= 0 || $tasa->updated_at->diffInHours($fechaActual) >= 6 ) {
            return redirect()
            ->route('tasa.index')
            ->with('status_danger', '¡Debes Actualizar el margen de gananacia para poder acceder!');
        }else{

            $cajaSessionid =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();
            // dd($cajaSessionid);
            $Caja = Caja::where("estado","=",'Abierta')->where("sessioncaja_id","=", $cajaSessionid->id)->first();

            if ($Caja) {

                if($Caja->user_id == Auth::id()){
                    $title='Nueva venta';
                    $personas = DB::table('personas')->where('tipo_persona', '=', 'Cliente')->get();
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

                    // return $articulos;
                    $UserId = Auth::id();
                    $caja = Caja::where("estado","=",'Abierta')->where("sessioncaja_id","=", $cajaSessionid->id)->first();
                    $ventaNum = Venta::latest('id')->first();
                    // dd(is_null($ventaNum));
                    if (is_null($ventaNum)) {

                        $num_comprobante = Sessioncaja::numCodigo('C', $UserId, 1);
                        $serie_comprobante = Sessioncaja::numCodigo('N', $UserId, 1);
                        // dd($serie_comprobante);
                    }else{
                        $num_comprobante = Sessioncaja::numCodigo('C', $UserId, $ventaNum->id+1);
                        $serie_comprobante = Sessioncaja::numCodigo('N', $UserId, $ventaNum->id+1);
                    }



                    $ventas = DB::table('ventas as v')
                        ->join('personas as p', 'v.persona_id', '=', 'p.id')
                        ->join('articulo_ventas as av', 'v.id', '=', 'av.venta_id')
                        ->join('cajas as c', 'v.caja_id', '=', 'c.sessioncaja_id')
                        ->join('users as u', 'u.id', '=', 'c.user_id')
                        ->select('u.name','c.user_id','v.id', 'v.fecha_hora','v.caja_id', 'c.sessioncaja_id', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.total_venta', 'v.estado')
                        ->where('c.user_id', '=', Auth::user()->id)
                        ->where('c.estado', '=', 'Abierta')
                        ->orderBy('v.id', 'desc')
                        ->groupBy('u.name','c.user_id','v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.total_venta', 'v.estado')
                        ->get();
                        // dd($tasaTransferenciaPunto);
                        // return $ventas;

                        // $sumaDivisa = Venta::find(6);
                        // $sumaDivisa->pago_ventas;
                        // $sumaDivisa->caja->user;

                    $cajas = Caja::find($Caja->id);
                    $cajas->user;
                    $cajas->ventas;
                    $cajas->pago_ventas;
                    $cajas->articulo_ventas;


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
                        $cajas->SumaTotalCantidadVentas = $cajas->SumaTotalCantidadVentas + 1;
                        }
                    }

                    foreach ($cajas->articulo_ventas as $art_vent ) {
                        $cajas->SumaArticulosVendidos = $cajas->SumaArticulosVendidos + $art_vent->cantidad;
                    }


                    //  return $ventas;
                    //dd($ventas);

                    return view('ventas.venta.create', compact('cajas','num_comprobante','serie_comprobante','caja', 'ventas','title','personas','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaMixto','tasaEfectivo','articulos'));
                }else{
                    return redirect()
                    ->route('caja.index')
                    ->with('status_danger', '¡Error de acceso! Solo se permite un usuario por caja para realizar ventas y ya se encuentra una caja abierta por otro usuario... ');
                }

            }
                return redirect()
                ->route('caja.index')
                ->with('status_danger', '¡Debes crear una caja para poder acceder!');


        }

    }

    public function store(Request $request)
    {
        // return $request;
    //     dd('hola');
        try{
            DB::beginTransaction();
            $myTime = Carbon::now('America/Caracas');
            // number_format($número, 2, '.', '');

            $articulo_id = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_costo_unidad = $request->get('precio_costo_unidad');

            //creamos un contador
            $cont = 0;
            $precio_costo_final = 0;
            //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            while ($cont < count($articulo_id)) {
                $precio_costo_final += $cantidad[$cont] * $precio_costo_unidad[$cont];

                $cont = $cont+1;
            }

            // return $precio_costo_final;
            $utilidad = $request->get('total_venta') - $precio_costo_final;



            $margen_gananacia = $utilidad / $request->get('total_venta');
            // dd($margen_gananacia);

            $venta = new Venta;
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->fecha_hora = $myTime->toDateTimeString();
            $venta->tipo_pago = $request->get('tipo_pago');
            $venta->tasaDolar = $request->get('tasaDolars');
            $venta->porDolar = $request->get('jmarjen_ganancia_dolar');
            $venta->tasaPeso = $request->get('tasaPesos');
            $venta->porPeso = $request->get('jmarjen_ganancia_peso');
            $venta->tasaTransPunto = $request->get('tasaTransPunto');
            $venta->porTransPunto = $request->get('jmarjen_ganancia_trans_punto');
            $venta->tasaMixto = $request->get('tasaMixto');
            $venta->porMixto = $request->get('jmarjen_ganancia_mixto');
            $venta->tasaEfectivo = $request->get('tasaEfectivo');
            $venta->porEfectivo = $request->get('jmarjen_ganancia_Efectivo');
            $venta->num_Punto = $request->get('num_Punto');
            $venta->num_Trans = $request->get('num_Trans');
            $venta->precio_costo = $precio_costo_final;
            $venta->margen_ganancia = $margen_gananacia;
            $venta->total_venta = $request->get('total_venta');
            $venta->ganancia_neta = $utilidad;
            $venta->estado = 'Aceptada';
            $venta->persona_id = $request->get('idcliente');
            $venta->caja_id = $request->get('caja_id');
            $venta->save();

            //cargamos los datos del detalle del venta en la tabla articulo_venta en unas variables que reciven
            //un array

            $tipo_pago = $request->get('tipo_pago');

            if ($tipo_pago == 'Dolar') {
                $precio_venta_unidad = $request->get('precio_venta');
            }elseif ($tipo_pago == 'Peso') {
                $precio_venta_unidad = $request->get('precio_venta_p');
            }elseif ($tipo_pago == 'Trans/Punto') {
                $precio_venta_unidad = $request->get('precio_venta_tp');
            }elseif ($tipo_pago == 'Mixto') {
                $precio_venta_unidad = $request->get('precio_venta_m');
            }elseif ($tipo_pago == 'Efectivo') {
                $precio_venta_unidad = $request->get('precio_venta_e');
            }


            $cantidad = $request->get('cantidad');
            $precio_costo_unidad = $request->get('precio_costo_unidad');
            $porEspecial = $request->get('porEspecial');

            $descuento = $request->get('descuento');
            $articulo_id = $request->get('idarticulo');

            //creamos un contador
            $cont = 0;

            //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            while ($cont < count($articulo_id)) {

                $isDivisa = Articulo::find($articulo_id[$cont]);

                if($isDivisa->isDolar){
                    $activoD = $isDivisa->isDolar;
                }else{
                    $activoD = null;
                }
                if($isDivisa->isPeso){
                    $activoP = $isDivisa->isPeso;
                }else{
                    $activoP = null;
                }
                if($isDivisa->isTransPunto){
                    $activoT = $isDivisa->isTransPunto;
                }else{
                    $activoT = null;
                }
                if($isDivisa->isMixto){
                    $activoM = $isDivisa->isMixto;
                }else{
                    $activoM = null;
                }
                if($isDivisa->isEfectivo){
                    $activoE = $isDivisa->isEfectivo;
                }else{
                    $activoE = null;
                }

                $Articulo_venta = new Articulo_venta();
                $Articulo_venta->cantidad = $cantidad[$cont];
                $Articulo_venta->precio_costo_unidad = $precio_costo_unidad[$cont];
                $Articulo_venta->precio_venta_unidad = $precio_venta_unidad[$cont];
                $Articulo_venta->porEspecial = $porEspecial[$cont];
                $Articulo_venta->isDolar = $activoD;
                $Articulo_venta->isPeso = $activoP;
                $Articulo_venta->isTransPunto = $activoT;
                $Articulo_venta->isMixto = $activoM;
                $Articulo_venta->isEfectivo = $activoE;
                $Articulo_venta->descuento = $descuento[$cont];
                $Articulo_venta->articulo_id = $articulo_id[$cont];
                $Articulo_venta->venta_id =  $venta->id;//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
                $Articulo_venta->save();

                $cont = $cont+1;
            }

            // $MontoDivisaR = $request->get('MontoDivisa');
            // $divisaR = $request->get('divisa');
            // $TasaTikeR = $request->get('TasaTike');
            // $MontoDolarR = $request->get('MontoDolar');
            // $VeltosR = $request->get('Veltos');

            // $MontoDivisaR = array_filter($MontoDivisaR);


            // foreach($MontoDivisaR as $key => $val) {


            //     $divisa[]=$divisaR[$key];
            //     $MontoDivisa[]=$MontoDivisaR[$key];
            //     $TasaTiket[]=$TasaTikeR[$key];
            //     $MontoDolar[]=$MontoDolarR[$key];
            //     $Vueltos[]=$VeltosR[$key];

            // }




            // // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
            // //creamos un contador
            // $cont = 0;

            // //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            // while ($cont < count($MontoDolar)) {


            //     $Pago_Venta = new Pago_Venta();
            //     $Pago_Venta->Divisa = $divisa[$cont];
            //     $Pago_Venta->MontoDivisa = $MontoDivisa[$cont];
            //     $Pago_Venta->TasaTiket = $TasaTiket[$cont];
            //     $Pago_Venta->MontoDolar = $MontoDolar[$cont];
            //     $Pago_Venta->Vueltos = $Vueltos[$cont];
            //     $Pago_Venta->venta_id = $venta->id;
            //     $Pago_Venta->save();

            //     $cont = $cont+1;
            // }

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
             /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        // TODO creamos metodo para realizar el pago cuando se paga con dinero contable viene en la variable base_vuelto_monto_dejado
                        // primero validamos si exciste un pago hecho.

                        $montoBase = $request->get('base_vuelto_monto_dejado');
                        $montoResta = $request->get('monto_dejadoResta');
                        $total_venta = $request->get('total_costo');


                        $montoBase = floatval($montoBase);
                        $montoResta = floatval($montoResta);
                        $total_venta = floatval($total_venta);

                        $modo_pago = 'contado';

                        $venta_id = $venta->id;
                        $caja_id = $request->get('caja_id');

                        $opS = $montoBase;

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //validamos si el monto pagado es mayor a 0 sea que lo paguen con montoBase o con montoPendiente y que el tipo de pago sea contado
                        if($opS > 0 && $modo_pago == 'contado'){
                            // return $opS;
                            //validamos que el monto pagado sea mayor o igual al total de la venta
                            if($opS >= $total_venta){
                                // return 'si';
                                // calculamos excedente si el valor pagado es mayor a la venta
                                // $MontoDolarR = $request->get('MontoDolar');
                                // return $montoD;
                                //validamos si montobase es mayor y montopendiente es menor... lo que significa esto es que estamos reciviendo una moneda nueva
                                if($montoBase > 0){
                                    // return 'pagado con plata nueva = montoBase';
                                    //metodo para procesar pago con dinero nuevo
                                    $montoD = [];
                                    $montoDiv = [];
                                    $TasaT = [];

                                    // $prueba[]= ['Divisa' => $divisaVueltos[$key], 'MontoDivisa' => $MontoDivisaVueltos[$key], 'TasaTiket' => $TasaTikeVueltos[$key], 'MontoDolar' => $MontoDolarVueltos[$key]];
                                    $MontoDivisa = $request->get('MontoDivisa');
                                    $divisa = $request->get('divisa');
                                    $TasaTike = $request->get('TasaTike');
                                    $MontoDolar = $request->get('MontoDolar');

                                    $MontoDolar = array_filter($MontoDolar);

                                    foreach($MontoDolar as $key => $val) {

                                        $DivisaArray[$divisa[$key]] = $divisa[$key];
                                        $montoDivisaArray[$divisa[$key]] = $MontoDivisa[$key];
                                        $TasaTikeArray[$divisa[$key]]= $TasaTike[$key];
                                        $montoDolarArray[$divisa[$key]]= $MontoDolar[$key];
                                    }

                                    // return $request;
                                    $restk = $total_venta;
                                    $totalVuelto = $montoResta;
                                    // echo  'total vuelto '.$totalVuelto.'<br>';
                                    // return $opS;
                                    //  $re[] = '';
                                    asort($montoDolarArray);
                                    foreach ($montoDolarArray as $key => $val) {
                                        if($val > 0){
                                            $montoD[$key]= $val;
                                            $montoDiv[$key]= $montoDivisaArray[$key];
                                            $TasaT[$key]= $TasaTikeArray[$key];
                                        }
                                    }
                                    // return $montoDiv;
                                    $x = $opS;
                                    $residuo = 0;
                                    $exc = 0;
                                    foreach ($montoD as $p => $value) {

                                        if(round($value,6) == round($restk,6)){
                                            echo 'igual <br> ';
                                            echo 'value '.$value.' <br> ';
                                            echo 'restk '.$restk.' <br> ';
                                            $restk = $restk - $value;
                                            $x = floatval($x - $value);
                                            $restk = floatval($restk);
                                            echo  ' divisa: '.$p.' montoDivisa: '.$montoDiv[$p].' tasaTiket: '.$TasaT[$p].' montoDolar: '.floatval($value).' montoDolarConsumo: '.floatval($value).'  excedente:  '. 0 .' vueltos: '. 0 .'<br> ';

                                            $Pago_Servicio = new Pago_Venta();
                                            $Pago_Servicio->Divisa = $p;
                                            $Pago_Servicio->MontoDivisa = $montoDiv[$p];
                                            $Pago_Servicio->TasaTiket = $TasaT[$p];
                                            $Pago_Servicio->MontoDolar = floatval($value);
                                            $Pago_Servicio->MontoDolarServicio = floatval($value);
                                            $Pago_Servicio->Excedente = 0;
                                            $Pago_Servicio->Vueltos = 0;
                                            $Pago_Servicio->venta_id = $venta_id;
                                            $Pago_Servicio->caja_id = $caja_id;
                                            $Pago_Servicio->save();



                                            echo 'excd '. 0 .' <br> ';
                                            echo 'vueltos '. 0 .' <br> ';
                                            echo $restk.' <br> ';
                                            $residuo = $restk;


                                        }else if (round($value,6) < round($restk,6)){

                                            echo 'value '.$value.' <br> ';
                                            echo 'restk '.$restk.' <br> ';
                                            echo 'menor <br> ';
                                            $restk = $restk - $value;
                                            echo  ' divisa: '.$p.' montoDivisa: '.$montoDiv[$p].' tasaTiket: '.$TasaT[$p].' montoDolar: '.floatval($value).' montoDolarConsumo: '.floatval($value).'  excedente:  '. 0 .' vueltos: '. 0 .'<br> ';


                                            $Pago_Servicio = new Pago_Venta();
                                            $Pago_Servicio->Divisa = $p;
                                            $Pago_Servicio->MontoDivisa = $montoDiv[$p];
                                            $Pago_Servicio->TasaTiket = $TasaT[$p];
                                            $Pago_Servicio->MontoDolar = floatval($value);
                                            $Pago_Servicio->MontoDolarServicio = floatval($value);
                                            $Pago_Servicio->Excedente = 0;
                                            $Pago_Servicio->Vueltos = 0;
                                            $Pago_Servicio->venta_id = $venta_id;
                                            $Pago_Servicio->caja_id = $caja_id;
                                            $Pago_Servicio->save();

                                            echo 'excd '. 0 .' <br> ';
                                            echo 'vueltos '. 0 .' <br> ';
                                            echo $restk.' <br> ';
                                            $residuo = $restk;
                                        }else if (round($value,6) > round($restk,6)){
                                            // echo 'value '.$value.' <br> ';
                                            // echo 'restk '.$restk.' <br> ';
                                            $residuo = $restk;
                                            $restk =   $value - $restk;
                                            // $vuel = $totalVuelto;
                                            // return $restk;
                                            // if($totalVuelto > 0){
                                                if (round($totalVuelto,6) > round($restk,6)) {
                                                    // $totalVuelto = $totalVuelto - $restk;
                                                    $exc = $restk;
                                                    $vuel = 0;
                                                }
                                                if (round($totalVuelto,6) < round($restk,6)) {

                                                    echo '$totalVuelto: '.$totalVuelto;
                                                    $exc = $restk - $totalVuelto;
                                                    $vuel = $totalVuelto;
                                                    $totalVuelto = 0;
                                                    // $residuo = 0;
                                                }
                                                // }
                                                if (round($totalVuelto,6) == round($restk,6)) {
                                                    $exc = 0;
                                                    $vuel = $totalVuelto;
                                                    $totalVuelto = 0;
                                                }
                                            echo 'mayor <br> ';
                                            echo  ' divisa: '.$p.' montoDivisa: '.$montoDiv[$p].' tasaTiket: '.$TasaT[$p].' montoDolar: '.floatval($value).' montoDolarConsumo: '.floatval($residuo).'  excedente:  '.$exc.' vueltos: '.$vuel.'<br> ';

                                            $Pago_Servicio = new Pago_Venta();
                                            $Pago_Servicio->Divisa = $p;
                                            $Pago_Servicio->MontoDivisa = $montoDiv[$p];
                                            $Pago_Servicio->TasaTiket = $TasaT[$p];
                                            $Pago_Servicio->MontoDolar = floatval($value);
                                            $Pago_Servicio->MontoDolarServicio = floatval($residuo);
                                            $Pago_Servicio->Excedente = $exc;
                                            $Pago_Servicio->Vueltos = $vuel;
                                            $Pago_Servicio->venta_id = $venta_id;
                                            $Pago_Servicio->caja_id = $caja_id;
                                            $Pago_Servicio->save();


                                            if($exc > 0){
                                                $excdtsRecibidosCaja = new ExcedentesRecibidosCajaActual();
                                                $excdtsRecibidosCaja->Tipo = 'Servicio';
                                                $excdtsRecibidosCaja->Estado = 'Pendiente';
                                                $excdtsRecibidosCaja->Divisa = $p;
                                                $excdtsRecibidosCaja->MontoDivisa = floatval($exc * $TasaT[$p]);
                                                $excdtsRecibidosCaja->TasaTiket = $TasaT[$p];
                                                $excdtsRecibidosCaja->MontoDolar = floatval($exc);
                                                $excdtsRecibidosCaja->venta_id = $venta_id;
                                                $excdtsRecibidosCaja->venta_id = 0;
                                                $excdtsRecibidosCaja->horas_extra_id = 0;
                                                $excdtsRecibidosCaja->caja_id = $caja_id;
                                                $excdtsRecibidosCaja->save();
                                                echo  'Excedentes_Recibidos_Caja_Actual Tipo: Servicio Estado: Pendiente Divisa: '.$p.' MontoDivisa: '.floatval($exc * $TasaT[$p]).' TasaTiket: '.$TasaT[$p].'  MontoDolar:  '.floatval($exc).'<br> ';
                                            }

                                            if($vuel > 0){
                                                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                // En esta seccion trabajaremos la parte de vueltos llenamos la tabla pagos_vueltos

                                                // $isVuelos = $request->get('isVueltos');

                                                if($montoResta > 0 || $montoResta != null){
                                                    $MontoDivisaVueltos = $request->get('MontoDivisaV');
                                                    $divisaVueltos = $request->get('divisaV');
                                                    $TasaTikeVueltos = $request->get('TasaTikeV');
                                                    $MontoDolarVueltos = $request->get('MontoDolarV');

                                                    $MontoDivisaVueltos = array_filter($MontoDivisaVueltos);

                                                    foreach($MontoDivisaVueltos as $key => $val) {

                                                        $Vdivisa[]=$divisaVueltos[$key];
                                                        $VMontoDivisa[]=$MontoDivisaVueltos[$key];
                                                        $VTasaTiket[]=$TasaTikeVueltos[$key];
                                                        $VMontoDolar[]=$MontoDolarVueltos[$key];
                                                    }
                                                    // dd($divisa, $MontoDivisa,$TasaTike,$MontoDolar,$Veltos);
                                                    //creamos un contador
                                                    $cont = 0;

                                                    //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
                                                    while ($cont < count($VMontoDolar)) {
                                                        $Pago_Extras_Vueltos = new PagoVuelto();
                                                        $Pago_Extras_Vueltos->Tipo = 'Servicio';
                                                        $Pago_Extras_Vueltos->tipo_vuelto = 'Vueltos_Pago';
                                                        $Pago_Extras_Vueltos->Divisa = $Vdivisa[$cont];
                                                        $Pago_Extras_Vueltos->MontoDivisa = $VMontoDivisa[$cont];
                                                        $Pago_Extras_Vueltos->TasaTiket = $VTasaTiket[$cont];
                                                        $Pago_Extras_Vueltos->MontoDolar = floatval($VMontoDolar[$cont]);
                                                        $Pago_Extras_Vueltos->venta_id = $venta_id;
                                                        $Pago_Extras_Vueltos->venta_id = 0;
                                                        $Pago_Extras_Vueltos->horas_extra_id = 0;
                                                        $Pago_Extras_Vueltos->detalle__creditos__pagado_id = 0;
                                                        $Pago_Extras_Vueltos->caja_id = $caja_id;
                                                        $Pago_Extras_Vueltos->save();

                                                        echo  'Pago_Vuelto Tipo: Consumo  Divisa: '.$Vdivisa[$cont].' MontoDivisa: '.$VMontoDivisa[$cont].' TasaTiket: '.$VTasaTiket[$cont].' MontoDolar: '.floatval($VMontoDolar[$cont]).'<br> ';
                                                        $cont = $cont+1;
                                                    }

                                                }
                                                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            }
                                            echo 'excd '.$exc.' <br> ';
                                            echo 'vueltos '.$vuel.' <br> ';
                                            echo $restk.' <br> ';
                                        }

                                    }
                                // validamos  si montopendiente es mayor y montobase es menor... lo que significa esto es que estamos reciviendo una moneda pendiente
                                }
// return 'Finalizo';

                            }else{
                                return Redirect::back()
                                ->with('status_danger', '¡Error Pago incompleto! Debe ingresar un monto para pagar y procesar el servicio... ');
                            }

                            // return 'no';
                        }

            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }

        return Redirect::to('ventas/venta/create')->with('success', 'La venta fué registrada exitosamente');
    }

    public function show($id)
    {
        // dd($id);
        $venta = DB::table('ventas as v')
            ->join('personas as p', 'v.persona_id', '=', 'p.id')
            ->join('articulo_ventas as av', 'v.id', '=', 'av.venta_id')
            ->select('v.id', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.total_venta', 'v.estado')
            ->where('v.id', '=', $id)
            ->first();

        //traemos los datos de la tabla detalle_venta
        $detalles = DB::table('articulo_ventas as av')
            ->join('articulos as a', 'av.articulo_id', '=', 'a.id')
            ->select('a.nombre as articulo', 'av.cantidad', 'av.descuento','av.precio_venta_unidad')
            ->where('av.venta_id', '=', $id)->get();

        return view("ventas.venta.show", ["venta" => $venta, "detalles"=> $detalles]);
    }

    public function destroy($id)
    {
        try{
            DB::beginTransaction();
        $venta = venta::findOrFail($id);
        $venta->estado = 'Cancelada';
        $venta->update();

        $detalleVenta = articulo_Venta::where('venta_id','=',$id)->get();


         //creamos un contador
         $cont = 0;

         //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
         while ($cont < count($detalleVenta)) {
            $idarticulo = $detalleVenta[$cont]->articulo_id;
            $articulo = Articulo::findOrFail($idarticulo);
            $articulo->stock = $articulo->stock+$detalleVenta[$cont]->cantidad;
            $articulo->update();

            $cont = $cont+1;

         };

         $registros = Pago_Venta::where('venta_id',$id)->get();
         foreach($registros as $registro){
            $ids[]=$registro->id;
        }


        if (isset($ids)) {
            $eliminados = Pago_Venta::destroy($ids);
        }


         DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            // dd($e);
        }

        return Redirect::to('ventas/venta');
    }
}

// DELIMITER //
// CREATE TRIGGER tr_updStockVenta AFTER INSERT ON detalle_venta
// FOR EACH ROW BEGIN
// 	UPDATE articulo SET stock = stock - NEW.cantidad
//     WHERE articulo.idarticulo = NEW.idarticulo;
// END
// //
// DELIMITER ;

// DELIMITER //
// CREATE TRIGGER tr_updStockVentas AFTER INSERT ON articulo_ventas
// FOR EACH ROW BEGIN
// 	UPDATE articulos SET stock = stock - NEW.cantidad
//     WHERE articulo.id = NEW.id;
// END
// //
// DELIMITER ;
