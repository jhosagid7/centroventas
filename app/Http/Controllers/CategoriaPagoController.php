<?php

namespace App\Http\Controllers;

use App\CategoriaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoriaPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
            // return $request;

        $nombre = $request->get('nombre');
        $condition = $request->get('condition');
        $description = $request->get('descripcion');
        $fecha = $request->get('fecha');
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');

        $fecha2 = $request->get('fecha2');

        if($request){

            $categorias=CategoriaPago::orderBy('id', 'DESC')
            ->nombre($nombre)
            ->condition($condition)
            ->description($description)
            ->fecha($fecha2)
            ->get();
            return view("pagos.categoria.index",["categorias"=>$categorias,"fechaInicio"=>$fechaInicio,"fechaFin"=>$fechaFin]);
        }

    }
    public function create()
    {
        return view('pagos.categoria.create');
    }
    public function store(Request $request)
    {
        // return 'store categoria';
        //creamos un objeto del modelo categoria
        $categoria = new CategoriaPago;
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion = 'Activa';
        $categoria->save();

        return Redirect::to('pagos/categoria')->with('status_success', 'Categoria registrada exitosamente');
    }
    public function show($id)
    {
        return view("pagos.categoria.show", ["categoria" => CategoriaPago::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("pagos.categoria.edit", ["categoria" => CategoriaPago::findOrFail($id)]);
    }
    public function update(Request $request,$id)
    {
        $categoria = CategoriaPago::findOrFail($id);
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->update();

        return redirect()
        ->route('categoria.index')
        ->with('status_success', 'Categoria actualizada exitosamente');


    }
    public function destroy($id)
    {
        // dd('categoria');
        $categoria = CategoriaPago::findOrFail($id);
        $categoria->condicion = 'Eliminada';
        $categoria->update();
        return redirect()
        ->route('categoria.index')
        ->with('status_success', 'Categoria eliminada exitosamente');

    }
}
