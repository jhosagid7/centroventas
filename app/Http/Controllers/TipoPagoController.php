<?php

namespace App\Http\Controllers;

use App\TipoPago;
use App\CategoriaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TipoPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {


            // return $request;
            // Recuperamos las variables
            $name = $request->get('name');
            $codigo = $request->get('codigo');
            $venderal = $request->get('venderal');
            $fecha = $request->get('fecha');
            $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');

            $categorias_id = $request->get('categorias_id');
            $fecha2 = $request->get('fecha2');

            $categorias = CategoriaPago::where('condicion', 'Activa')->get();


            if (empty($name) and empty($codigo) and empty($venderal) and empty($categorias_id)){
                $articulos = TipoPago::paginate(1000);
            }else{

            // Traemos los datos
            $articulos = TipoPago::name($name)
            ->codigo($codigo)
            ->venderal($venderal)
            ->Categoria_id($categorias_id)
            ->fecha($fecha2)
            ->where('articulos.estado', 'Activo')
            // ->select('a.id', 'a.codigo', 'a.nombre', 'a.stock', 'a.precio_costo', 'a.unidades', 'a.descripcion', 'a.imagen', 'a.estado', 'c.nombre as categoria')
            ->orderBy('id', 'desc')
            ->paginate(1000);
            }
            // return $articulos;
// return $articulos;
            // return redirect()->back()->withInput();
            return view('pagos.tipo.index', ["categorias" => $categorias,"articulos" => $articulos,"oldCat" => $categorias_id,"name" => $name,"codigo" => $codigo,"venderal" => $venderal,"fechaInicio" => $fechaInicio,"fechaFin" => $fechaFin]);

    }
    public function create()
    {
        $categorias = CategoriaPago::where('condicion', 'Activa')->get();
        return view('pagos.tipo.create', ['categorias'=>$categorias]);
    }
    public function store(Request $request)
    {
        // return $request->all();
        //creamos un objeto del modelo categoria
        $articulo = new TipoPago;
        $articulo->nombre       = $request->get('nombre');
        $articulo->descripcion  = $request->get('descripcion');
        $articulo->categoria_pago_id  = $request->get('categoria_id');
        $articulo->save();

        return Redirect::to('pagos/tipo')->with('status_success', 'Articulo registrado exitosamente');
    }


    public function show($id)
    {
        return view("pagos.tipo.show", ["articulo" => TipoPago::findOrFail($id)]);
    }


    public function edit($id)
    {
        $articulo = TipoPago::findOrFail($id);
        $categorias = CategoriaPago::where('condicion', 'Activa')->get();
        return view("pagos.tipo.edit", ["articulo" => $articulo, 'categorias'=> $categorias]);
    }
    public function update(Request $request, $id)
    {
        $articulo = TipoPago::findOrFail($id);
        $articulo->nombre       = $request->get('nombre');
        $articulo->descripcion  = $request->get('descripcion');
        $articulo->categoria_pago_id  = $request->get('categoria_id');
        $articulo->update();

        return Redirect::to('pagos/tipo')->with('status_success', 'El Tipo de pago fue actualizado exitosamente');
    }
    public function destroy($id)
    {
        // dd('hola');
        $articulo = TipoPago::findOrFail($id);
        $articulo->estado = 'Inactivo';
        $articulo->update();

        return redirect()
        ->route('tipo.index')
        ->with('status_success', 'El Tipo de pago fue Eliminado exitosamente');

        // return Redirect::to('almacen/articulo')->with('El Artículo fue Eliminado exitosamente');
    }
}
