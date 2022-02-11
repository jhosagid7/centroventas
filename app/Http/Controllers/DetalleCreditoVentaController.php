<?php

namespace App\Http\Controllers;

use App\Tasa;
use App\Venta;
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
        $creditos = Venta::where('tipo_pago_condicion', 'Credito')->where('persona_id', $request->id)->get();
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
        //
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
        $creditos = Ingreso::where('tipo_pago', 'Credito')->where('id', $id)->take(1000)->first();
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

        return view('ventas.creditos.show', compact('creditos',
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
