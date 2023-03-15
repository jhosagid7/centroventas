<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tasa;
use App\Cuenta;
use App\Articulo;
use App\Servicio;
use App\TipoPago;
use App\Sessioncaja;
use App\Transaccion;
use App\PagoServicio;
use App\CategoriaPago;
use App\Transferencia;
use App\SaldosMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
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
    public function index(Request $request)
    {
        // return $request;
        $fecha = $request->get('fecha');

        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $fecha2 = $request->get('fecha2');

        $nombre = $request->get('nombre');
        $categoria = $request->get('categoria');
        $tipo = $request->get('tipo');
        $rif = $request->get('num_documento');

        $title = 'Pagos Realizados';
        $servicios = Servicio::orderBy('id','DESC')
        ->nombre($nombre)
        ->categoria($categoria)
        ->tipo($tipo)
        ->rif($rif)
        ->fecha($fecha2)
        ->paginate(10000);

        $categorias = CategoriaPago::all();
        $tipos = TipoPago::all();

        return view('pagos.servicio.index', compact('servicios', 'title', 'fechaInicio', 'fechaFin', 'fecha2', 'categorias', 'tipos'));
    }

    public function getServiciosOrigenes(Request $request){
        // return $request;
        if ($request->ajax()) {
            $origenArticulos = TipoPago::where('categoria_pago_id', $request->accion)->get();

                // return $origenesArtArray;
                return response()->json($origenArticulos);
        }
    }

    public function getProductoDestinos(Request $request){
        // return $request;
        // return $request->ajax();
        if ($request->ajax()) {

            if ($request->tipo == 'Mayor') {
                $tipo = 'Detal';
            } else {
                $tipo = 'Mayor';
            }

            $origenDestinos = Articulo::where('vender_al', '=', $tipo)
                ->where('estado', '=', 'Activo')
                ->where('stock', '>=', '0')
                ->get();


                return response()->json($origenDestinos);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Gestion de pago';

        $User = Auth::user()->name;
        $categorias = CategoriaPago::all();

        $saldo_banco_dolar = self::get_saldo_banco("Dolar");
        $saldo_banco_peso = self::get_saldo_banco("Peso");
        $saldo_banco_bolivar = self::get_saldo_banco("Bolivar");
        $saldo_banco_punto = self::get_saldo_banco("Punto");
        $saldo_banco_transferencia = self::get_saldo_banco("Transferencia");


        $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
        $tasaPeso = Tasa::where('nombre', 'Peso')->first();
        $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
        $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();
        // return $articulos;
        return view('pagos.servicio.create', compact('User', 'categorias','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaEfectivo','saldo_banco_dolar','saldo_banco_peso','saldo_banco_bolivar','saldo_banco_punto','saldo_banco_transferencia'));

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
        $contd = $request->get('contd');
        $credito_id = $request->get('credito_id');

        $nombre_acre = $request->get('nombre_acre');
        $documento_acre = $request->get('documento_acre');
        $tipo_acre = $request->get('tipo_acre');
        $tipo_id_acre = $request->get('tipo_id_acre');
        $servicio_acre = $request->get('servicio_acre');
        $servicio_id_acre = $request->get('servicio_id_acre');

        $total_operador_reg_input = $request->get('total_operador_reg_input');
        $total_sistema_reg_input = $request->get('total_sistema_reg_input');
        $total_dif_input = $request->get('total_dif_input');
        $Observaciones = $request->get('Observaciones');

        $dif_moneda_dolar_to_tasa_input = $request->get('dif_moneda_dolar_to_tasa_input');
        $dif_moneda_peso_to_tasa_input = $request->get('dif_moneda_peso_to_tasa_input');
        $dif_moneda_efectivo_to_tasa_input = $request->get('dif_moneda_efectivo_to_tasa_input');
        $dif_moneda_punto_to_tasa_input = $request->get('dif_moneda_punto_to_tasa_input');
        $dif_moneda_trans_to_tasa_input = $request->get('dif_moneda_trans_to_tasa_input');

        $TasaDolar = $request->get('TasaDolar');
        $TasaPeso = $request->get('TasaPeso');
        $TasaPunto = $request->get('TasaPunto');
        $TasaTrans = $request->get('TasaTrans');
        $TasaBolivar = $request->get('TasaBolivar');

        $tasa_dolar_rep = $request->get('tasa_dolar_rep');
        $tasa_peso_rep = $request->get('tasa_peso_rep');
        $tasa_punto_rep = $request->get('tasa_punto_rep');
        $tasa_trans_rep = $request->get('tasa_trans_rep');
        $tasa_efectivo_rep = $request->get('tasa_efectivo_rep');

        $deuda = $request->get('deuda_acre');



        if($total_operador_reg_input == $deuda){
            $UserName = $request->user()->name;
            $UserId = $request->user()->id;
            $caja =  Caja::where('hora_cierre', 'Sin cerrar')->orderBy('id', 'desc')->first();
            // return $caja;

            $detalleCredito = New Servicio();
            $detalleCredito->nombre = $nombre_acre;
            $detalleCredito->num_documento = $documento_acre;
            $detalleCredito->deuda = $deuda;
            $detalleCredito->observaciones = $request->get('Observaciones');
            $detalleCredito->user_id = $UserId;
            $detalleCredito->categoria_pago_id = $tipo_id_acre;
            $detalleCredito->tipo_pago_id = $servicio_id_acre;
            $detalleCredito->caja_id = $caja->id;
            $detalleCredito->save();


            if ($Observaciones){
                $denominacion = $request->get('Observaciones');
            }

            $correlativo_transaccion = Transaccion::count();
            $correlativo_transaccion = $correlativo_transaccion + 1;

            $transaccion = new Transaccion();
            $transaccion->correlativo    = $correlativo_transaccion;
            $transaccion->descripcion_op = 'Pago Operativo: ' . $tipo_acre . ' - ' . $servicio_acre . ' con factura ID ' . $detalleCredito->id;
            $transaccion->codigo         = $caja->id;
            $transaccion->denominacion   = $Observaciones;
            $transaccion->operador       = $UserName;
            $transaccion->save();

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Consultamos en que monedas nos estan pagado y las guardamos

            if (!empty($request->get('dif_moneda_dolar_to_tasa_input')) && $request->get('dif_moneda_dolar_to_tasa_input') > 0) {
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
                $saldos_movimientos->debe           = 0;
                $saldos_movimientos->haber          = $request->get('dif_moneda_dolar_to_tasa_input');
                $saldos_movimientos->saldo          = $saldo_dolar - $request->get('dif_moneda_dolar_to_tasa_input');
                $saldos_movimientos->cuenta_id      = 1;
                $saldos_movimientos->transaccion_id = $transaccion->id;
                $saldos_movimientos->save();

                if($saldos_movimientos){
                    $saldo_dolar = $request->get('dif_moneda_dolar_to_tasa_input');
                    if($saldo_dolar){
                        $MontoDivisa = $saldo_dolar;
                        if($tasa_dolar_rep > 0){
                            $Tasa = $tasa_dolar_rep;
                        }else{
                            $Tasa = $TasaDolar;
                        }
                        $MontoDolar = $saldo_dolar / $Tasa;
                    }

                    $Pago_Credito = new PagoServicio();
                    $Pago_Credito->Divisa = 'Dolar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaDolar;
                    $Pago_Credito->TasaRecived = $tasa_dolar_rep;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->servicio_id = $detalleCredito->id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }
            }

            if (!empty($request->get('dif_moneda_peso_to_tasa_input')) && $request->get('dif_moneda_peso_to_tasa_input') > 0) {
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
                $saldos_movimientos->debe           = 0;
                $saldos_movimientos->haber          = $request->get('dif_moneda_peso_to_tasa_input');
                $saldos_movimientos->saldo          = $saldo_peso - $request->get('dif_moneda_peso_to_tasa_input');
                $saldos_movimientos->cuenta_id      = 2;
                $saldos_movimientos->transaccion_id = $transaccion->id;
                $saldos_movimientos->save();

                if($saldos_movimientos){
                    $saldo_peso = $request->get('dif_moneda_peso_to_tasa_input');
                    if($saldo_peso){
                        $MontoDivisa = $saldo_peso;
                        if($tasa_peso_rep > 0){
                            $Tasa = $tasa_peso_rep;
                        }else{
                            $Tasa = $TasaPeso;
                        }
                        $MontoDolar = $saldo_peso / $Tasa;
                    }

                    $Pago_Credito = new PagoServicio();
                    $Pago_Credito->Divisa = 'Peso';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPeso;
                    $Pago_Credito->TasaRecived = $tasa_peso_rep;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->servicio_id = $detalleCredito->id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }
            }

            if (!empty($request->get('dif_moneda_efectivo_to_tasa_input')) && $request->get('dif_moneda_efectivo_to_tasa_input') > 0) {
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
                $saldos_movimientos->debe           = 0;
                $saldos_movimientos->haber          = $request->get('dif_moneda_efectivo_to_tasa_input');
                $saldos_movimientos->saldo          = $saldo_bolivar - $request->get('dif_moneda_efectivo_to_tasa_input');
                $saldos_movimientos->cuenta_id      = 3;
                $saldos_movimientos->transaccion_id = $transaccion->id;
                $saldos_movimientos->save();

                if($saldos_movimientos){
                    $saldo_efectivo = $request->get('dif_moneda_efectivo_to_tasa_input');
                    if($saldo_efectivo){
                        $MontoDivisa = $saldo_efectivo;
                        if($tasa_efectivo_rep > 0){
                            $Tasa = $tasa_efectivo_rep;
                        }else{
                            $Tasa = $TasaBolivar;
                        }
                        $MontoDolar = $saldo_efectivo / $Tasa;
                    }

                    $Pago_Credito = new PagoServicio();
                    $Pago_Credito->Divisa = 'Bolivar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaBolivar;
                    $Pago_Credito->TasaRecived = $tasa_efectivo_rep;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->servicio_id = $detalleCredito->id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

            }

            if (!empty($request->get('dif_moneda_punto_to_tasa_input')) && $request->get('dif_moneda_punto_to_tasa_input') > 0) {
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
                $saldos_movimientos->debe           = 0;
                $saldos_movimientos->haber          = $request->get('dif_moneda_punto_to_tasa_input');
                $saldos_movimientos->saldo          = $saldo_punto - $request->get('dif_moneda_punto_to_tasa_input');
                $saldos_movimientos->cuenta_id      = 4;
                $saldos_movimientos->transaccion_id = $transaccion->id;
                $saldos_movimientos->save();

                if($saldos_movimientos){
                    $saldo_punto = $request->get('dif_moneda_punto_to_tasa_input');
                    if($saldo_punto){
                        $MontoDivisa = $saldo_punto;
                        if($tasa_punto_rep > 0){
                            $Tasa = $tasa_punto_rep;
                        }else{
                            $Tasa = $TasaPunto;
                        }
                        $MontoDolar = $saldo_punto / $Tasa;
                    }

                    $Pago_Credito = new PagoServicio();
                    $Pago_Credito->Divisa = 'Punto';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPunto;
                    $Pago_Credito->TasaRecived = $tasa_punto_rep;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->servicio_id = $detalleCredito->id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }
            }

            if (!empty($request->get('dif_moneda_trans_to_tasa_input')) && $request->get('dif_moneda_trans_to_tasa_input') > 0) {
                $correlativo_trans = SaldosMovimiento::where('cuenta_id', 5)->count();
                $saldo_trans = SaldosMovimiento::where('cuenta_id', 5)->latest('id')->first();
                if($saldo_trans){
                    $saldo_trans = $saldo_trans->saldo;
                }else{
                    $saldo_trans = 0;
                }
                $correlativo_trans = $correlativo_trans + 1;
                // Guardamos los montos recibidos en caja en banco
                $saldos_movimientos = new SaldosMovimiento();
                $saldos_movimientos->correlativo    = $correlativo_trans;
                $saldos_movimientos->debe           = 0;
                $saldos_movimientos->haber          = $request->get('dif_moneda_trans_to_tasa_input');
                $saldos_movimientos->saldo          = $saldo_trans - $request->get('dif_moneda_trans_to_tasa_input');
                $saldos_movimientos->cuenta_id      = 5;
                $saldos_movimientos->transaccion_id = $transaccion->id;
                $saldos_movimientos->save();

                if($saldos_movimientos){
                    $saldo_trans = $request->get('dif_moneda_trans_to_tasa_input');
                    if($saldo_trans){
                        $MontoDivisa = $saldo_trans;
                        if($tasa_trans_rep > 0){
                            $Tasa = $tasa_trans_rep;
                        }else{
                            $Tasa = $TasaTrans;
                        }
                        $MontoDolar = $saldo_trans / $Tasa;
                    }

                    $Pago_Credito = new PagoServicio();
                    $Pago_Credito->Divisa = 'Transferencia';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaTrans;
                    $Pago_Credito->TasaRecived = $tasa_trans_rep;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->servicio_id = $detalleCredito->id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }
            }




    }else{
        return redirect()
        ->route('servicios.index')
        ->with('status_danger  Error. EL monto pagado debe ser exacto...');
    }

        // return $creditos->moto;
        return redirect()
        ->route('servicios.index')
        ->with('status_success  El pago operativo se registro Exitosamente. ¡Que tengas una exitosa jornada!');
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Factura de pago servicios';
        $servicio = Servicio::find($id);
        $pagos_servicios = PagoServicio::where('servicio_id', $id)->get();
        $pagos_servicios_suma = PagoServicio::where('servicio_id', $id)->sum('MontoDolar');

        return view('pagos.servicio.show', compact('title', 'servicio', 'pagos_servicios', 'pagos_servicios_suma'));
    }

    public function get_saldo_banco($banco){
        $datosBancos = Cuenta::all();
        foreach($datosBancos as $datosBanco){
            if($datosBanco->moneda == "$banco"){
                $saldo_banco = SaldosMovimiento::where('cuenta_id',$datosBanco->numero_cuenta)->orderBy('created_at', 'desc')->first();
            }
        }
        return $saldo_banco;
    }
}
