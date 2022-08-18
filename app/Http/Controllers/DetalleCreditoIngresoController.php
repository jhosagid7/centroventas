<?php

namespace App\Http\Controllers;

use App\Tasa;
use App\Cuenta;
use App\Ingreso;
use App\Persona;
use App\PagoIngreso;
use App\Sessioncaja;
use App\Transaccion;
use App\CreditoIngreso;
use App\ProveedorCredito;
use App\SaldosMovimiento;
use Illuminate\Http\Request;
use App\DetalleCreditoIngreso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DetalleCreditoIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        $title='Creditos ingresos';
        // $query = trim($request->get('buscarTexto'));
        $creditos = ProveedorCredito::where('total_factura', '>' , 0)->get();

        return view('compras.credito.index', compact('creditos','title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return $request;
        $title = 'Recivo de Credito';
        $creditos = Ingreso::where('tipo_pago', 'Credito')->where('persona_id', $request->id)->get();
        // return $creditos;
        $saldo_banco_dolar = self::get_saldo_banco("Dolar");
        $saldo_banco_peso = self::get_saldo_banco("Peso");
        $saldo_banco_bolivar = self::get_saldo_banco("Bolivar");
        $saldo_banco_punto = self::get_saldo_banco("Punto");
        $saldo_banco_transferencia = self::get_saldo_banco("Transferencia");


        $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
        $tasaPeso = Tasa::where('nombre', 'Peso')->first();
        $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
        $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();

        $credito_id = $request->id;

        return view('compras.credito.create', compact('creditos','title',
        'Articulo_Ingresos',
        'saldo_banco_dolar',
        'saldo_banco_peso',
        'saldo_banco_bolivar',
        'saldo_banco_punto',
        'saldo_banco_transferencia',
        'tasaDolar',
        'tasaPeso',
        'tasaTransferenciaPunto',
        'tasaEfectivo',
        'credito_id'));
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

        $total_descuento_reg_input = $request->get('total_descuento_reg_input');
        $total_aumento_reg_input = $request->get('total_aumento_reg_input');

        $creditos = DetalleCreditoIngreso::where('ingreso_id', $credito_id)->orderBy('created_at', 'desc')->first();

        if ($creditos->resta > 0) {
            if($total_operador_reg_input < (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input)) {
                //abonamos a la factura
                $UserName = $request->user()->name;
                $UserId = $request->user()->id;
                $caja =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();

                $detalleCredito = New DetalleCreditoIngreso();
                $detalleCredito->ingreso_id = $credito_id;
                $detalleCredito->proveedor = $creditos->proveedor;
                $detalleCredito->operador = $UserId;
                $detalleCredito->caja = $caja->id;
                $detalleCredito->moto = (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input);
                $detalleCredito->abono = $total_operador_reg_input;
                $detalleCredito->resta = (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input) - $total_operador_reg_input;
                $detalleCredito->descuento = $total_descuento_reg_input;
                $detalleCredito->incremento = $total_aumento_reg_input;
                $detalleCredito->observaciones = $request->get('Observaciones');
                $detalleCredito->save();


                if ($Observaciones){
                    $denominacion = "Monto pagado por el operador $UserName con ID Factura: $credito_id. ". $request->get('Observaciones');
                }else{
                    $denominacion = "Monto pagado por el operador $UserName con ID Factura: $credito_id.";
                }

                $correlativo_transaccion = Transaccion::count();
                $correlativo_transaccion = $correlativo_transaccion + 1;

                $transaccion = new Transaccion();
                $transaccion->correlativo    = $correlativo_transaccion;
                $transaccion->descripcion_op = 'Por el Pago de Crdito de ingreso id ' . $credito_id;
                $transaccion->codigo         = $caja->id;
                $transaccion->denominacion   = $denominacion;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Dolar';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaDolar;
                        $Pago_Credito->TasaRecived = $tasa_dolar_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Peso';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaPeso;
                        $Pago_Credito->TasaRecived = $tasa_peso_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Bolivar';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaBolivar;
                        $Pago_Credito->TasaRecived = $tasa_efectivo_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Punto';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaPunto;
                        $Pago_Credito->TasaRecived = $tasa_punto_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Transferencia';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaTrans;
                        $Pago_Credito->TasaRecived = $tasa_trans_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
                        $Pago_Credito->caja_id = $caja->id;
                        $Pago_Credito->save();
                    }
                }


                    if($creditos->proveedor){
                        $proveedor = Persona::findOrFail($creditos->proveedor);

                        $isDeuda = ProveedorCredito::where('persona_id', $proveedor->id)->first();

                        if(isset($isDeuda) and $isDeuda->total_factura > 0){
                            // return $isDeuda->total_factura;
                            $proveedorCredito = ProveedorCredito::findOrFail($isDeuda->id);
                            // $proveedorCredito->total_factura += 1;
                            $proveedorCredito->total_deuda -= $total_operador_reg_input;
                            $proveedorCredito->update();
                        }


                        }
                }

            }
            if($total_operador_reg_input >= (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input)){
                $UserName = $request->user()->name;
                $UserId = $request->user()->id;
                $caja =  Sessioncaja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();

                $detalleCredito = New DetalleCreditoIngreso();
                $detalleCredito->ingreso_id = $credito_id;
                $detalleCredito->proveedor = $creditos->proveedor;
                $detalleCredito->operador = $UserId;
                $detalleCredito->caja = $caja->id;
                $detalleCredito->moto = (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input);
                $detalleCredito->abono = $total_operador_reg_input;
                $detalleCredito->resta = (($creditos->resta + $total_aumento_reg_input) - $total_descuento_reg_input) - $total_operador_reg_input;
                $detalleCredito->descuento = $total_descuento_reg_input;
                $detalleCredito->incremento = $total_aumento_reg_input;
                $detalleCredito->observaciones = $request->get('Observaciones');
                $detalleCredito->save();


                if ($Observaciones){
                    $denominacion = "Monto pagado por el operador $UserName con ID Factura: $credito_id. ". $request->get('Observaciones');
                }else{
                    $denominacion = "Monto pagado por el operador $UserName con ID Factura: $credito_id.";
                }

                $correlativo_transaccion = Transaccion::count();
                $correlativo_transaccion = $correlativo_transaccion + 1;

                $transaccion = new Transaccion();
                $transaccion->correlativo    = $correlativo_transaccion;
                $transaccion->descripcion_op = 'Por el Pago de Crdito de ingreso id ' . $credito_id;
                $transaccion->codigo         = $caja->id;
                $transaccion->denominacion   = $denominacion;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Dolar';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaDolar;
                        $Pago_Credito->TasaRecived = $tasa_dolar_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Peso';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaPeso;
                        $Pago_Credito->TasaRecived = $tasa_peso_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Bolivar';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaBolivar;
                        $Pago_Credito->TasaRecived = $tasa_efectivo_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Punto';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaPunto;
                        $Pago_Credito->TasaRecived = $tasa_punto_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
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

                        $Pago_Credito = new PagoIngreso();
                        $Pago_Credito->Divisa = 'Transferencia';
                        $Pago_Credito->MontoDivisa = $MontoDivisa;
                        $Pago_Credito->TasaTiket = $TasaTrans;
                        $Pago_Credito->TasaRecived = $tasa_trans_rep;
                        $Pago_Credito->MontoDolar = $MontoDolar;
                        $Pago_Credito->Vueltos = 0;
                        $Pago_Credito->ingreso_id = $credito_id;
                        $Pago_Credito->caja_id = $caja->id;
                        $Pago_Credito->save();
                    }
                }

                if($creditos->proveedor){
                    $proveedor = Persona::findOrFail($creditos->proveedor);

                    $isDeuda = ProveedorCredito::where('persona_id', $proveedor->id)->first();

                    if(isset($isDeuda) and $isDeuda->total_factura > 0){
                        // return $isDeuda->total_factura;
                        $proveedorCredito = ProveedorCredito::findOrFail($isDeuda->id);
                        $proveedorCredito->total_factura -= 1;
                        $proveedorCredito->total_deuda -= $total_operador_reg_input;
                        $proveedorCredito->update();
                    }

            }

            $ingreso_pago = Ingreso::findOrFail($credito_id);
            $ingreso_pago->status = 'Pagado';
            $ingreso_pago->update();

            $CreditoIngreso = CreditoIngreso::where('ingreso_id' , $credito_id)->first();
            $CreditoIngreso->estado_credito_ingreso = 'Pagado';
            $CreditoIngreso->update();
        }

        // return $creditos->moto;
        return redirect()
        ->route('credito.index')
        ->with('status_success  La Caja fué Abierta exitosamente. ¡Que tengas una exitosa jornada!');
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetalleCreditoIngreso  $detalleCreditoIngreso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Recivo de Credito';
        $creditos = Ingreso::where('tipo_pago', 'Credito')->where('id', $id)->where('status', 'Pendiente')->first();
        // return $creditos;
        $saldo_banco_dolar = self::get_saldo_banco("Dolar");
        $saldo_banco_peso = self::get_saldo_banco("Peso");
        $saldo_banco_bolivar = self::get_saldo_banco("Bolivar");
        $saldo_banco_punto = self::get_saldo_banco("Punto");
        $saldo_banco_transferencia = self::get_saldo_banco("Transferencia");


        $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
        $tasaPeso = Tasa::where('nombre', 'Peso')->first();
        $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
        $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();

        $credito_id = $id;

        return view('compras.credito.show', compact('creditos',
        'title',
        'Articulo_Ingresos',
        'saldo_banco_dolar',
        'saldo_banco_peso',
        'saldo_banco_bolivar',
        'saldo_banco_punto',
        'saldo_banco_transferencia',
        'tasaDolar',
        'tasaPeso',
        'tasaTransferenciaPunto',
        'tasaEfectivo',
        'credito_id'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetalleCreditoIngreso  $detalleCreditoIngreso
     * @return \Illuminate\Http\Response
     */
    public function edit(DetalleCreditoIngreso $detalleCreditoIngreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetalleCreditoIngreso  $detalleCreditoIngreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetalleCreditoIngreso $detalleCreditoIngreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetalleCreditoIngreso  $detalleCreditoIngreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetalleCreditoIngreso $detalleCreditoIngreso)
    {
        //
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
