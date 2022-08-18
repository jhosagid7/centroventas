<?php

namespace App\Http\Controllers;

use App\User;
use App\Articulo;
use App\Transaction;
use Illuminate\Http\Request;
use App\Articulo_transactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CargoController extends Controller
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
        $operador = $request->get('operador');
        $estado = $request->get('estado');

        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $fecha2 = $request->get('fecha2');

        $users = User::where('id','<>', '1')->where('id','<>', '2')->get();
// return $request;
        $cargos = Transaction::where('tipo_operacion', '=', 'Cargo')
        ->fecha($fecha2)
        ->operador($operador)
        ->estado($estado)
        ->orderBy('id','Desc')
        ->get();
        return view('transactions.cargos.index', compact('cargos','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articulos = Articulo::where('estado', '=', 'Activo')
        ->get();

        $idSerie = Transaction::where('tipo_operacion', '=', 'Cargo')->count('id');
        $idUsuario = Auth::user()->id;
        // return $idUsuario;
        if(!empty($idSerie)){
            $id_cod = $idSerie + 1;
            $num_documento = Transaction::numCodigo('CG', $idUsuario, $id_cod);
        }else{
            $id_cod = 1;
            $num_documento = Transaction::numCodigo('CG', $idUsuario, $id_cod);
        }
        // return $num_documento;

        return view('transactions.cargos.create', compact('articulos','num_documento'));
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

            $transaction = new Transaction;
            $transaction->tipo_operacion = $request->get('tipo_operacion');
            $transaction->deposito = $request->get('deposito');
            $transaction->num_documento = $request->get('num_documento');
            $transaction->user_id = $request->user()->id;
            $transaction->autorizado_por = $request->get('autorizado_por');
            $transaction->proposito = $request->get('proposito');
            $transaction->detalle = $request->get('detalle');
            $transaction->total_operacion = $request->get('total');
            $transaction->estado = 'Aceptado';
            $transaction->save();

            //cargamos los datos del detalle del ingreso en unas variables que reciven
            //un array

            $articulo_id = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_costo_unidad = $request->get('precio_compra');
            $observacion = $request->get('observacion');


            //creamos un contador
            $cont = 0;

            //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            while ($cont < count($articulo_id)) {

                $Articulo_transaction = new Articulo_transactions();
                $Articulo_transaction->cantidad = $cantidad[$cont];
                $Articulo_transaction->precio_costo_unidad = $precio_costo_unidad[$cont];
                $Articulo_transaction->articulo_id = $articulo_id[$cont];
                $Articulo_transaction->transaction_id = $transaction->id;
                $Articulo_transaction->observacion = $observacion[$cont];
                $Articulo_transaction->save();

                $articulo = Articulo::findOrFail($articulo_id[$cont]);
                $articulo->stock = $articulo->stock+$cantidad[$cont];
                $articulo->precio_costo = $precio_costo_unidad[$cont];
                $articulo->update();

                $cont = $cont+1;
            }

            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            // dd($e);
        }

        return redirect()->action('CargoController@show', $transaction->id)->with('success', 'El Cargo fué registrado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Recivo de Cargo';
        $cargos = Transaction::findOrfail($id);

        return view("transactions.cargos.show", compact('title', 'cargos'));
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
        try{
            DB::beginTransaction();
        $transaction = Transaction::findOrFail($id);
        $transaction->estado = 'Cancelado';
        $transaction->update();

        $detalleArticuloTransaction = Articulo_transactions::where('transaction_id','=',$id)->get();

         //creamos un contador
         $cont = 0;

         //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
         while ($cont < count($detalleArticuloTransaction)) {
            $idarticulo = $detalleArticuloTransaction[$cont]->articulo_id;
            $articulo = Articulo::findOrFail($idarticulo);
            $articulo->stock = $articulo->stock-$detalleArticuloTransaction[$cont]->cantidad;
            $articulo->update();

            $cont = $cont+1;

         };
         DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }

        return Redirect::to('cargos');
    }
}
