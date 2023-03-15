<?php

namespace App\Http\Controllers;

use App\Caja;

use App\Tasa;
use Response;
use App\Cuenta;
use App\Ingreso;
use App\Persona;
use App\Articulo;
use Carbon\Carbon;
use App\PagoIngreso;
use App\Sessioncaja;
use App\Transaccion;

use App\DetalleVenta;

use App\Http\Requests;
//use Illuminate\Http\Response;
use App\CreditoIngreso;
use App\DetalleIngreso;
use App\Articulo_Ingreso;
use App\ProveedorCredito;
use App\SaldosMovimiento;
use Illuminate\Http\Request;
use App\DetalleCreditoIngreso;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\IngresoFormRequest;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // return 'index ingreso';
        if ($request) {
            $title='Ingresos';
            // $query = trim($request->get('buscarTexto'));
            $ingresos = DB::table('ingresos as i')
                ->join('personas as p', 'i.persona_id', '=', 'p.id')
                ->join('users as u', 'i.user_id', '=', 'u.id')
                ->join('articulo__ingresos as ai', 'i.id', '=', 'ai.ingreso_id')
                ->select('i.id', 'u.name', 'i.fecha_hora', 'i.tipo_pago', 'i.status', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado', DB::raw('sum(ai.cantidad*precio_costo_unidad) as total'))
                // ->where('i.num_comprobante', 'LIKE', '%'. $query  .'%')
                ->orderBy('i.id', 'desc')
                ->groupBy('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado')
                ->get();

            return view('compras.ingreso.index', ["title"=>$title,"ingresos" => $ingresos]);
        }
    }

    public function create()
    {
        $personas = DB::table('personas')->where('tipo_persona', '=', 'Proveedor')->get();
        $articulos = DB::table('articulos as art')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.id', 'art.precio_costo')
            ->where('art.estado', '=', 'Activo')
            ->get();

            $saldo_banco_dolar = self::get_saldo_banco("Dolar");
            $saldo_banco_peso = self::get_saldo_banco("Peso");
            $saldo_banco_bolivar = self::get_saldo_banco("Bolivar");
            $saldo_banco_punto = self::get_saldo_banco("Punto");
            $saldo_banco_transferencia = self::get_saldo_banco("Transferencia");


            $tasaDolar = Tasa::where('nombre', 'Dolar')->first();
            $tasaPeso = Tasa::where('nombre', 'Peso')->first();
            $tasaTransferenciaPunto = Tasa::where('nombre', 'Transferencia_Punto')->first();
            $tasaEfectivo = Tasa::where('nombre', 'Efectivo')->first();

        // $nombre_banco = $datosBanco->nombre_cuenta;
        // $moneda_banco = $datosBanco->moneda;
        // $title = 'Relacion Banco Moneda '.$moneda_banco;
        // $saldosMovimientos = SaldosMovimiento::where('cuenta_id',$id)->take(25)->orderBy('created_at', 'desc')->get();
        // $saldos_bancos_dolar = Bancos::where()->firtst();

        return view('compras.ingreso.create', ["personas" => $personas, "articulos" => $articulos, "tasaEfectivo" => $tasaEfectivo, "tasaTransferenciaPunto" => $tasaTransferenciaPunto, "tasaDolar" => $tasaDolar, "tasaPeso" => $tasaPeso, "saldo_banco_dolar" => $saldo_banco_dolar, "saldo_banco_peso" => $saldo_banco_peso, "saldo_banco_bolivar" => $saldo_banco_bolivar, "saldo_banco_punto" => $saldo_banco_punto, "saldo_banco_transferencia" => $saldo_banco_transferencia]);
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

    public function store(Request $request)
    {
        // return $request->all();

        try{
            DB::beginTransaction();

            if ($request->get('credt') == 1){
                $tipo_pago = 'Credito';
                $status = 'Pendiente';
            }

            if ($request->get('contd') == 1){
                $tipo_pago = 'Contado';
                $status = 'Pagado';
            }


            $ingreso = new Ingreso; //(*) al guardar genera un idingreso automatimanente que luego se usa en la tabla detalle
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $ingreso->precio_compra = $request->get('total');




            $myTime = Carbon::now('America/Caracas');
            $ingreso->fecha_hora = $myTime->toDateTimeString();
            $ingreso->estado = 'Aceptado';
            $ingreso->tipo_pago = $tipo_pago;
            $ingreso->status = $status;
            $ingreso->persona_id = $request->get('idproveedor');
            $ingreso->user_id = $request->user()->id;
            // return $ingreso;
            $ingreso->save();

            //cargamos los datos del detalle del ingreso en unas variables que reciven
            //un array

            $articulo_id = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_costo_unidad = $request->get('precio_compra');


            //creamos un contador
            $cont = 0;

            //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            while ($cont < count($articulo_id)) {

                $Articulo_Ingreso = new Articulo_Ingreso();
                $Articulo_Ingreso->cantidad = $cantidad[$cont];
                $Articulo_Ingreso->precio_costo_unidad = $precio_costo_unidad[$cont];
                $Articulo_Ingreso->ingreso_id = $ingreso->id;
                $Articulo_Ingreso->articulo_id = $articulo_id[$cont];
                $Articulo_Ingreso->save();

                $cont = $cont+1;
            }

            $UserName = $request->user()->name;
            $UserId = $request->user()->id;
            $caja =  Caja::where('hora_cierre', 'Sin cerrar')->orderBy('id', 'desc')->first();

            if ($tipo_pago == 'Credito'){

                if($request->get('idproveedor')){
                    $proveedor = Persona::findOrFail($request->get('idproveedor'));

                    $isDeuda = ProveedorCredito::where('persona_id', $proveedor->id)->first();
                    // return $isDeuda;

                    if(isset($isDeuda)){
                        // return 'if ' . $isDeuda->total_factura;
                        $proveedorCredito = ProveedorCredito::findOrFail($isDeuda->id);
                        $proveedorCredito->total_factura += 1;
                        $proveedorCredito->total_deuda += $request->get('total');
                        $proveedorCredito->update();
                    }else{
                        // return 'else ' . $isDeuda->total_factura;
                        $proveedorCredito = New ProveedorCredito();
                        $proveedorCredito->nombre_cliente = $proveedor->nombre;
                        $proveedorCredito->cedula_cliente = $proveedor->num_documento;
                        $proveedorCredito->direccion_cliente = $proveedor->direccion;
                        $proveedorCredito->telefono_cliente = $proveedor->telefono;
                        $proveedorCredito->total_factura = 1;
                        $proveedorCredito->total_deuda = $request->get('total');
                        // $proveedorCredito->fecha_limite_pago = $request->get('total');
                        $proveedorCredito->estado_credito = 'Activo';
                        $proveedorCredito->persona_id = $proveedor->id;
                        $proveedorCredito->user_id = $UserId;
                        $proveedorCredito->save();


                    }
                    // return 'aquí';
                    $creditoIngreso = New CreditoIngreso();
                    $creditoIngreso->ingreso_id = $ingreso->id;
                    $creditoIngreso->proveedor_credito_id = $proveedorCredito->id;
                    $creditoIngreso->estado_credito_ingreso = 'Pendiente';
                    $creditoIngreso->save();

                    $detalleCredito = New DetalleCreditoIngreso();
                    $detalleCredito->ingreso_id = $ingreso->id;
                    $detalleCredito->proveedor = $request->get('idproveedor');
                    $detalleCredito->operador = $UserId;
                    $detalleCredito->caja = $caja->id;
                    $detalleCredito->moto = $request->get('total');
                    $detalleCredito->abono = 0;
                    $detalleCredito->resta = $request->get('total');
                    $detalleCredito->descuento = 0;
                    $detalleCredito->incremento = 0;
                    $detalleCredito->observaciones = $request->get('Observaciones');
                    $detalleCredito->save();
                }

            }


            if ($tipo_pago == 'Contado') {

                if ($request->get('Observaciones')){
                    $denominacion = $request->get('Observaciones');
                }

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
                $transaccion->descripcion_op = 'Pago de ingreso de productos';
                $transaccion->codigo         = $caja->id;
                $transaccion->denominacion   = $request->get('Observaciones');
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
                        $Pago_Credito->ingreso_id = $ingreso->id;
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
                        $Pago_Credito->ingreso_id = $ingreso->id;
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
                        $Pago_Credito->ingreso_id = $ingreso->id;
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
                        $Pago_Credito->ingreso_id = $ingreso->id;
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
                        $Pago_Credito->ingreso_id = $ingreso->id;
                        $Pago_Credito->caja_id = $caja->id;
                        $Pago_Credito->save();
                    }
                }
            }

            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
            return $e;
            return Redirect::to('compras/ingreso')->with("status_danger", "El Ingreso fué registrado con error $e");
            // dd($e);
        }

        return Redirect::to('compras/ingreso')->with('status_success', 'El Ingreso fué registrado exitosamente');
    }

    public function show($id)
    {
        $title = 'Reporte de Ingreso';

        $ingreso = DB::table('ingresos as i')
                ->join('personas as p', 'i.persona_id', '=', 'p.id')
                ->join('users as u', 'i.user_id', '=', 'u.id')
                ->join('articulo__ingresos as ai', 'i.id', '=', 'ai.ingreso_id')
                ->select('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado', DB::raw('sum(ai.cantidad*precio_costo_unidad) as total'))
                ->where('i.id', '=', $id)
                ->orderBy('i.id', 'desc')
                ->groupBy('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado')
                ->get();

        //traemos los datos de la tabla detalle_articulos
        $Articulo_Ingresos = DB::table('articulo__ingresos as ai')
            ->join('articulos as a', 'ai.articulo_id', '=', 'a.id')
            ->select('a.nombre as articulo', 'ai.cantidad', 'ai.precio_costo_unidad')
            ->where('ai.ingreso_id', '=', $id)->get();

            // return $ingreso;

        return view("compras.ingreso.show", ["title" => $title, "ingreso" => $ingreso, "Articulo_Ingresos"=> $Articulo_Ingresos]);
    }

    public function destroy($id)
    {
        try{
            DB::beginTransaction();
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'Cancelado';
        $ingreso->update();

        $detalleIngreso = Articulo_Ingreso::where('ingreso_id','=',$id)->get();

         //creamos un contador
         $cont = 0;

         //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
         while ($cont < count($detalleIngreso)) {
            $idarticulo = $detalleIngreso[$cont]->articulo_id;
            $articulo = Articulo::findOrFail($idarticulo);
            $articulo->stock = $articulo->stock-$detalleIngreso[$cont]->cantidad;
            $articulo->update();

            $cont = $cont+1;

         };
         DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }

        return Redirect::to('compras/ingreso');
    }

    public function exportToPDF(){
        $ingresos = Ingreso::get();
        $pdf = PDF::loadView('compras.ingreso.exportToPdf', Compact('ingresos'));
        $pdf->setPaper('a4', 'landscape');

        // $order          = Order::find($id);
        // $customer       = Customer::find($order->customer_id);
        // $shipping       = Shipping::find($order->shipping_id);
        // $orderDetails   = OrderDetail::where('order_id', $order->id)->get();

        // $pdf = PDF::loadView('admin.order.download-invoice',[
        //     'order'=> $order,
        //     'customer'=>$customer,
        //     'shipping'=>$shipping,
        //     'orderDetails'=>$orderDetails
        // ]);

        // return $pdf->download('invoice.pdf');
//        return $pdf->stream('invoice.pdf');
        return $pdf->download('ListadoIngresos.pdf');
    }
}
