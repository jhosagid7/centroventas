<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Tasa;
use App\Cuenta;
use App\Transaccion;
use App\CategoriaPago;
use App\SaldosMovimiento;
use App\TransaccionesBanco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BancoController extends Controller
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
        $title = 'Cuentas';
        $cuentas =  Cuenta::all();


        return view('bancos.banco.index', compact('cuentas','title'));
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
        // return $request;
        $UserName = $request->user()->name;
        $UserId = $request->user()->id;
        $concepto = $request->get('Observaciones');
        $tasa_destino = $request->get('tasa_destino');
        $saldo_banco_dolar = $request->get('saldo_banco_dolar');
        $saldo_banco_peso = $request->get('saldo_banco_peso');
        $saldo_banco_punto = $request->get('saldo_banco_punto');
        $saldo_banco_bolivar = $request->get('saldo_banco_bolivar');
        $monto_debitar = $request->get('monto_debitar');
        $monto_transferir = $request->get('monto_transferir');
        $operador = $UserName;

        list($banco_origen_id, $banco_origen) = explode(":", $request->get('bancoOrigen'));
        list($banco_destiono_id, $banco_destiono) = explode(":", $request->get('Bdestino'));

        if($banco_destiono == 'Dolar'){
            $cuenta =  Cuenta::where('moneda', 'Dolar')->first();
        }
        if($banco_destiono == 'Peso'){
            $cuenta =  Cuenta::where('moneda', 'Peso')->first();
        }
        if($banco_destiono == 'Efectivo'){
            $cuenta =  Cuenta::where('moneda', 'Bolivar')->first();
        }
        if($banco_destiono == 'Transferencia_Punto'){
            $cuenta =  Cuenta::where('moneda', 'Punto')->first();
        }



        $caja =  Caja::where('hora_cierre', 'Sin cerrar')->orderBy('id', 'desc')->first();
        // return $caja;

        $TransaccionesBanco = New TransaccionesBanco();
        $TransaccionesBanco->concepto = $concepto;
        $TransaccionesBanco->banco_origen = $banco_origen;
        $TransaccionesBanco->banco_destiono = $cuenta->moneda;
        $TransaccionesBanco->tasa_destino = $tasa_destino;
        $TransaccionesBanco->saldo_banco_dolar = $saldo_banco_dolar;
        $TransaccionesBanco->saldo_banco_peso = $saldo_banco_peso;
        $TransaccionesBanco->saldo_banco_punto = $saldo_banco_punto;
        $TransaccionesBanco->saldo_banco_bolivar = $saldo_banco_bolivar;
        $TransaccionesBanco->monto_debitar = $monto_debitar;
        $TransaccionesBanco->monto_transferir = $monto_transferir;
        $TransaccionesBanco->operador = $operador;
        $TransaccionesBanco->caja_id = $caja->id;
        $TransaccionesBanco->save();



            $denominacion = $request->get('Observaciones');




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Devitamos de la cuenta origen el saldo

        if (!empty($monto_debitar) && $monto_debitar > 0) {
            $correlativo_transaccion = Transaccion::count();
            $correlativo_transaccion = $correlativo_transaccion + 1;

            $transaccion = new Transaccion();
            $transaccion->correlativo    = $correlativo_transaccion;
            $transaccion->descripcion_op = 'Retiro por transferencia: realizada a la cuenta local en ' . $cuenta->moneda . ' con ID trasferencia ' . $TransaccionesBanco->id;
            $transaccion->codigo         = $caja->id;
            $transaccion->denominacion   = $denominacion;
            $transaccion->operador       = $UserName;
            $transaccion->save();

            $correlativo_dolar = SaldosMovimiento::where('cuenta_id', $banco_origen_id)->count();
            $correlativo_dolar = $correlativo_dolar + 1;
            $saldo = SaldosMovimiento::where('cuenta_id', $banco_origen_id)->latest('id')->first();
            if($saldo){
                $saldo = $saldo->saldo;
            }else{
                $saldo = 0;
            }
            // Guardamos los montos recibidos en caja en banco
            $saldos_movimientos = new SaldosMovimiento();
            $saldos_movimientos->correlativo    = $correlativo_dolar;
            $saldos_movimientos->debe           = 0;
            $saldos_movimientos->haber          = $monto_debitar;
            $saldos_movimientos->saldo          = $saldo - $monto_debitar;
            $saldos_movimientos->cuenta_id      = $banco_origen_id;
            $saldos_movimientos->transaccion_id = $transaccion->id;
            $saldos_movimientos->save();
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Sumamos el saldo en la cuenta destino de la cuenta origen el saldo

        if (!empty($monto_transferir) && $monto_transferir > 0) {
            $correlativo_transaccion = Transaccion::count();
            $correlativo_transaccion = $correlativo_transaccion + 1;

            $transaccion = new Transaccion();
            $transaccion->correlativo    = $correlativo_transaccion;
            $transaccion->descripcion_op = 'Ingreso por transferencia: realizada de la cuenta local en ' . $banco_origen . ' con ID trasferencia ' . $TransaccionesBanco->id;
            $transaccion->codigo         = $caja->id;
            $transaccion->denominacion   = $denominacion;
            $transaccion->operador       = $UserName;
            $transaccion->save();

            $correlativo_dolar = SaldosMovimiento::where('cuenta_id', $cuenta->id)->count();
            $correlativo_dolar = $correlativo_dolar + 1;
            $saldo = SaldosMovimiento::where('cuenta_id', $cuenta->id)->latest('id')->first();
            if($saldo){
                $saldo = $saldo->saldo;
            }else{
                $saldo = 0;
            }
            // Guardamos los montos recibidos en caja en banco
            $saldos_movimientos = new SaldosMovimiento();
            $saldos_movimientos->correlativo    = $correlativo_dolar;
            $saldos_movimientos->debe           = $monto_transferir;
            $saldos_movimientos->haber          = 0;
            $saldos_movimientos->saldo          = $saldo + $monto_transferir;
            $saldos_movimientos->cuenta_id      = $cuenta->id;
            $saldos_movimientos->transaccion_id = $transaccion->id;
            $saldos_movimientos->save();
        }

        return Redirect::to('bancos/banco')->with('status_success', 'La Transferencia se realizo exitosamente...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datosBanco = Cuenta::findOrFail($id);
        $nombre_banco = $datosBanco->nombre_cuenta;
        $moneda_banco = $datosBanco->moneda;
        $title = 'Relacion Banco Moneda '.$moneda_banco;
        $saldosMovimientos = SaldosMovimiento::where('cuenta_id',$id)->take(25)->orderBy('created_at', 'desc')->get();

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

        $cuentas =  Cuenta::where('id', $id)->first();
        if($cuentas->moneda == 'Dolar'){
            $moneda = 'Dolar';
        }
        if($cuentas->moneda == 'Peso'){
            $moneda = 'Peso';
        }
        if($cuentas->moneda == 'Bolivar'){
            $moneda = 'Efectivo';
        }
        if($cuentas->moneda == 'Punto'){
            $moneda = 'Transferencia_punto';
        }
        if($cuentas->moneda == 'Transferencia'){
            $moneda = 'Transferencia_punto';
        }
        $cuenta_tasa = Tasa::where('nombre','<>',$moneda)->where('nombre','<>','Mixto')->where('nombre','<>','EfectivoVenta')->get();
        $banco_origen =  Cuenta::findOrFail($id);

        // return $saldosMovimientos;

        return view('bancos.banco.show', compact('banco_origen','cuenta_tasa','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaEfectivo','User','categorias','saldo_banco_peso','saldo_banco_bolivar','saldo_banco_punto','saldo_banco_transferencia','saldo_banco_dolar','saldosMovimientos','title','nombre_banco','moneda_banco'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $request;
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
