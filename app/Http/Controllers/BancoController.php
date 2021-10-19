<?php

namespace App\Http\Controllers;

use App\Cuenta;
use App\SaldosMovimiento;
use Illuminate\Http\Request;

class BancoController extends Controller
{
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
        $datosBanco = Cuenta::findOrFail($id);
        $nombre_banco = $datosBanco->nombre_cuenta;
        $moneda_banco = $datosBanco->moneda;
        $title = 'Relacion Banco Moneda '.$moneda_banco;
        $saldosMovimientos = SaldosMovimiento::where('cuenta_id',$id)->get();

        // return $saldosMovimientos;

        return view('bancos.banco.show', compact('saldosMovimientos','title','nombre_banco','moneda_banco'));
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
