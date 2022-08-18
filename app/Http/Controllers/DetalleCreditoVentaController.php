<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tasa;
use App\Venta;
use App\Persona;
use App\PagoCredito;
use App\Sessioncaja;
use App\CreditoVenta;
use App\ClienteCredito;
use App\DetalleCreditoVenta;
use Illuminate\Http\Request;

class DetalleCreditoVentaController extends Controller
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
        $title='Creditos Ventas';
        // $query = trim($request->get('buscarTexto'));
        $creditos = ClienteCredito::where('total_factura', '>' , 0)->get();

        return view('ventas.creditos.index', compact('creditos','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return $request;
        $title = 'Recivo de Credito Cliente';
        $creditos = Venta::where('tipo_pago_condicion', 'Credito')->where('status','Pendiente')->where('persona_id', $request->id)->get();
        // return $creditos;



        $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
        $tasaPeso = Tasa::where('nombre', 'Peso')->first();
        $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
        $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();

        $credito_id = $request->id;

        return view('ventas.creditos.create', compact('creditos','title',
        'Articulo_Ingresos',
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
        return $request;
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

        $creditos = DetalleCreditoVenta::where('venta_id', $credito_id)->orderBy('created_at', 'desc')->first();

        if ($creditos->resta > 0) {
            if($total_operador_reg_input < $creditos->resta) {
                //abonamos a la factura
                $UserName = $request->user()->name;
                $UserId = $request->user()->id;
                $caja =  Caja::where('hora_cierre', 'Sin cerrar')->orderBy('id', 'desc')->first();

                $detalleCredito = New DetalleCreditoVenta();
                $detalleCredito->venta_id = $credito_id;
                $detalleCredito->cliente = $creditos->cliente;
                $detalleCredito->operador = $UserId;
                $detalleCredito->caja_id = $caja->id;
                $detalleCredito->moto = $creditos->resta;
                $detalleCredito->abono = $total_operador_reg_input;
                $detalleCredito->resta = $creditos->resta - $total_operador_reg_input;
                $detalleCredito->descuento = 0;
                $detalleCredito->incremento = 0;
                $detalleCredito->observaciones = $request->get('Observaciones');
                $detalleCredito->save();


                if ($Observaciones){
                    $denominacion = $request->get('Observaciones');
                }



                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Consultamos en que monedas nos estan pagado y las guardamos

                if (!empty($request->get('dif_moneda_dolar_to_tasa_input')) && $request->get('dif_moneda_dolar_to_tasa_input') > 0) {

                    $saldo_dolar = $request->get('dif_moneda_dolar_to_tasa_input');
                    if($saldo_dolar){
                        $MontoDivisa = $saldo_dolar;
                        $MontoDolar = $saldo_dolar / $TasaDolar;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Dolar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaDolar;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_peso_to_tasa_input')) && $request->get('dif_moneda_peso_to_tasa_input') > 0) {
                    $saldo_peso = $request->get('dif_moneda_peso_to_tasa_input');
                    if($saldo_peso){
                        $MontoDivisa = $saldo_peso;
                        $MontoDolar = $saldo_peso / $TasaPeso;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Peso';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPeso;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_efectivo_to_tasa_input')) && $request->get('dif_moneda_efectivo_to_tasa_input') > 0) {
                    $saldo_efectivo = $request->get('dif_moneda_efectivo_to_tasa_input');
                    if($saldo_efectivo){
                        $MontoDivisa = $saldo_efectivo;
                        $MontoDolar = $saldo_efectivo / $TasaBolivar;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Bolivar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaBolivar;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_punto_to_tasa_input')) && $request->get('dif_moneda_punto_to_tasa_input') > 0) {
                    $saldo_punto = $request->get('dif_moneda_punto_to_tasa_input');
                    if($saldo_punto){
                        $MontoDivisa = $saldo_punto;
                        $MontoDolar = $saldo_punto / $TasaPunto;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Punto';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPunto;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_trans_to_tasa_input')) && $request->get('dif_moneda_trans_to_tasa_input') > 0) {
                    $saldo_trans = $request->get('dif_moneda_trans_to_tasa_input');
                    if($saldo_trans){
                        $MontoDivisa = $saldo_trans;
                        $MontoDolar = $saldo_trans / $TasaTrans;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Transferencia';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaTrans;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }


                    if($creditos->cliente){
                        $cliente = Persona::findOrFail($creditos->cliente);

                        $isDeuda = ClienteCredito::where('persona_id', $cliente->id)->first();

                        if(isset($isDeuda) and $isDeuda->total_factura > 0){
                            // return $isDeuda->total_factura;
                            $clienteCredito = ClienteCredito::findOrFail($isDeuda->id);
                            // $proveedorCredito->total_factura += 1;
                            $clienteCredito->total_deuda -= $total_operador_reg_input;
                            $clienteCredito->update();
                        }


                        }
                }

            }
            if($total_operador_reg_input >= $creditos->resta){
                $UserName = $request->user()->name;
                $UserId = $request->user()->id;
                $caja =  Caja::where('hora_cierre', 'Sin cerrar')->orderBy('id', 'desc')->first();

                $detalleCredito = New DetalleCreditoVenta();
                $detalleCredito->venta_id = $credito_id;
                $detalleCredito->cliente = $creditos->cliente;
                $detalleCredito->operador = $UserId;
                $detalleCredito->caja_id = $caja->id;
                $detalleCredito->moto = $creditos->resta;
                $detalleCredito->abono = $total_operador_reg_input;
                $detalleCredito->resta = $creditos->resta - $total_operador_reg_input;
                $detalleCredito->descuento = 0;
                $detalleCredito->incremento = 0;
                $detalleCredito->observaciones = $request->get('Observaciones');
                $detalleCredito->save();


                if ($Observaciones){
                    $denominacion = $request->get('Observaciones');
                }

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // Consultamos en que monedas nos estan pagado y las guardamos

                if (!empty($request->get('dif_moneda_dolar_to_tasa_input')) && $request->get('dif_moneda_dolar_to_tasa_input') > 0) {

                    $saldo_dolar = $request->get('dif_moneda_dolar_to_tasa_input');
                    if($saldo_dolar){
                        $MontoDivisa = $saldo_dolar;
                        $MontoDolar = $saldo_dolar / $TasaDolar;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Dolar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaDolar;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_peso_to_tasa_input')) && $request->get('dif_moneda_peso_to_tasa_input') > 0) {
                    $saldo_peso = $request->get('dif_moneda_peso_to_tasa_input');
                    if($saldo_peso){
                        $MontoDivisa = $saldo_peso;
                        $MontoDolar = $saldo_peso / $TasaPeso;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Peso';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPeso;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_efectivo_to_tasa_input')) && $request->get('dif_moneda_efectivo_to_tasa_input') > 0) {
                    $saldo_efectivo = $request->get('dif_moneda_efectivo_to_tasa_input');
                    if($saldo_efectivo){
                        $MontoDivisa = $saldo_efectivo;
                        $MontoDolar = $saldo_efectivo / $TasaBolivar;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Bolivar';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaBolivar;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_punto_to_tasa_input')) && $request->get('dif_moneda_punto_to_tasa_input') > 0) {
                    $saldo_punto = $request->get('dif_moneda_punto_to_tasa_input');
                    if($saldo_punto){
                        $MontoDivisa = $saldo_punto;
                        $MontoDolar = $saldo_punto / $TasaPunto;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Punto';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaPunto;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if (!empty($request->get('dif_moneda_trans_to_tasa_input')) && $request->get('dif_moneda_trans_to_tasa_input') > 0) {
                    $saldo_trans = $request->get('dif_moneda_trans_to_tasa_input');
                    if($saldo_trans){
                        $MontoDivisa = $saldo_trans;
                        $MontoDolar = $saldo_trans / $TasaTrans;
                    }

                    $Pago_Credito = new PagoCredito();
                    $Pago_Credito->Divisa = 'Transferencia';
                    $Pago_Credito->MontoDivisa = $MontoDivisa;
                    $Pago_Credito->TasaTiket = $TasaTrans;
                    $Pago_Credito->MontoDolar = $MontoDolar;
                    $Pago_Credito->Vueltos = 0;
                    $Pago_Credito->venta_id = $credito_id;
                    $Pago_Credito->caja_id = $caja->id;
                    $Pago_Credito->save();
                }

                if($creditos->cliente){
                    $cliente = Persona::findOrFail($creditos->cliente);

                    $isDeuda = ClienteCredito::where('persona_id', $cliente->id)->first();

                    if(isset($isDeuda) and $isDeuda->total_factura > 0){
                        if($total_operador_reg_input > $creditos->resta){
                            $total_operador_reg_input = $creditos->resta;
                        }elseif ($total_operador_reg_input == $creditos->resta) {
                            $total_operador_reg_input = $total_operador_reg_input;
                        }
                        // return $isDeuda->total_factura;
                        $clienteCredito = ClienteCredito::findOrFail($isDeuda->id);
                        $clienteCredito->total_factura -= 1;
                        $clienteCredito->total_deuda -= $total_operador_reg_input;
                        $clienteCredito->update();
                    }

            }

            $venta_pago = Venta::findOrFail($credito_id);
            $venta_pago->status = 'Pagado';
            $venta_pago->estado_credito = 'Pagado';
            $venta_pago->update();

            $CreditoVenta = CreditoVenta::where('venta_id' , $credito_id)->first();
            $CreditoVenta->estado_credito_venta = 'Pagado';
            $CreditoVenta->update();
        }

        // return $creditos->moto;
        return redirect()
        ->route('creditos.index')
        ->with('status_success  La Caja fué Abierta exitosamente. ¡Que tengas una exitosa jornada!');
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetalleCreditoVenta  $detalleCreditoVenta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Recivo de Credito Cliente';
        $creditos = Venta::where('tipo_pago_condicion', 'Credito')->where('status','Pendiente')->where('id', $id)->first();
        // return $creditos;



        $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
        $tasaPeso = Tasa::where('nombre', 'Peso')->first();
        $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
        $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();

        $credito_id = $id;
        // return $creditos;

        return view('ventas.creditos.show', compact('creditos',
        'title',
        'Articulo_Ingresos',
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
     * @param  \App\DetalleCreditoVenta  $detalleCreditoVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(DetalleCreditoVenta $detalleCreditoVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetalleCreditoVenta  $detalleCreditoVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetalleCreditoVenta $detalleCreditoVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetalleCreditoVenta  $detalleCreditoVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetalleCreditoVenta $detalleCreditoVenta)
    {
        //
    }
}
