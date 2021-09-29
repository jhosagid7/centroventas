<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Transferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;


class TransferenciaController extends Controller
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
        $nombre = $request->get('nombre');
        $accion = $request->get('accion');
        $fecha = $request->get('fecha');

        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $fecha2 = $request->get('fecha2');

        $title = 'Transferencias Realizadas';
        $transferencias = Transferencia::orderBy('id','DESC')
        ->nombre($nombre)
        ->accion($accion)
        ->fecha($fecha2)
        ->paginate(10000);

        return view('almacen.transferencia.index', compact('transferencias', 'title', 'fechaInicio', 'fechaFin', 'fecha2'));
    }

    public function getProductoOrigenes(Request $request){
        // return $request;
        if ($request->ajax()) {
            $origenArticulos = Articulo::where('vender_al', $request->accion)
                ->where('stock', '>', '0')
                ->get();

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
        $title = 'Transferir Artiuclo';

        $User = Auth::user()->name;
        // return $articulos;
        return view('almacen.transferencia.create', compact('User'));

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

            $origenId = $request->get('origen_id');
            $destinoId = $request->get('destino_id');
            $cantidadRestarOrigen = $request->get('selctOrigen');
            $cantidadSumarDestino = $request->get('origenSelecct');
            $verStock = $request->get('verStock');
            $verStockDestino = $request->get('verStockDestino');

            $articuloOrigen = Articulo::findOrFail($origenId);
            $articuloOrigen->stock = $verStock;
            $articuloOrigen->update();

            $articuloDestino = Articulo::findOrFail($destinoId);
            $articuloDestino->stock = $verStockDestino;
            $articuloDestino->update();

            $transferencia = new Transferencia;
            $transferencia->accion = $request->get('accion');
            $transferencia->origen_id = $origenId;
            $transferencia->origenNombreProducto = $request->get('origenNombre');
            $transferencia->origenStockInicial = $request->get('origenStock');
            $transferencia->origenStockFinal = $request->get('verStock');
            $transferencia->origenUnidades = $request->get('origenUnidades');
            $transferencia->origenVender_al = $request->get('origenVender_al');
            $transferencia->cantidadRestarOrigen = $cantidadRestarOrigen;
            $transferencia->destino_id = $destinoId;
            $transferencia->destinoNombreProducto = $request->get('destinoNombre');
            $transferencia->destinoStockInicial = $request->get('destinoStock');
            $transferencia->destinoStockFinal = $request->get('verStockDestino');
            $transferencia->destinoUnidades = $request->get('destinoUnidades');
            $transferencia->destinoVender_al = $request->get('destinoVender_al');
            $transferencia->cantidadSumarDestino = $cantidadSumarDestino;
            $transferencia->operador = $request->get('operador');
            $transferencia->save();



            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            return redirect()
            ->route('transferencia.index')
            ->with('status_danger', 'No se pueden cargar los datos en este momento, Por favor Intentalo más Tarde..!');
        }

        return redirect()
        ->route('transferencia.index')
        ->with('status_success', 'La Transferencia se Ha Realizado Exitosamente...!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Reporte de Transferencia';
        $transferencia = Transferencia::find($id);

        return view('almacen.transferencia.show', compact('title', 'transferencia'));
    }


}
