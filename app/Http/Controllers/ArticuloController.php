<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Categoria;
use App\Http\Requests;

use Illuminate\support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ArticuloFormRequest;


class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        // return $request; p
        if ($request) {
            $name = $request->get('name');
            $codigo = $request->get('codigo');
            $venderal = $request->get('venderal');
            $fecha = $request->get('fecha');
            $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');

            $fecha2 = $request->get('fecha2');
            $categorias_id = $request->get('categorias_id');



            $tasaDolar = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();
            $tasaPeso = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Peso')->first();
            $tasaTransferenciaPunto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Transferencia_Punto')->first();
            $tasaMixto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Mixto')->first();
            $tasaEfectivo = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Efectivo')->first();
            $categorias = Categoria::where('condicion', 'Activa')->get();

            $articulos = Articulo::select('articulos.id', 'articulos.codigo', 'articulos.nombre', 'articulos.stock', 'articulos.precio_costo', 'articulos.unidades', 'articulos.descripcion', 'articulos.imagen', 'articulos.estado', 'articulos.porEspecial', 'articulos.isDolar', 'articulos.isPeso', 'articulos.isTransPunto', 'articulos.isMixto', 'articulos.isEfectivo', 'categorias.nombre as categoria')
            ->join('categorias', 'articulos.categoria_id', '=', 'categorias.id')
            // $articulos = DB::table('articulos as a')
            // ->join('categorias as c', 'a.categoria_id', '=', 'c.id')
            ->name($name)
            ->codigo($codigo)
            ->venderal($venderal)
            ->Categoria_id($categorias_id)
            ->fecha($fecha2)
            ->where('articulos.estado', 'Activo')
            // ->select('a.id', 'a.codigo', 'a.nombre', 'a.stock', 'a.precio_costo', 'a.unidades', 'a.descripcion', 'a.imagen', 'a.estado', 'c.nombre as categoria')
            ->orderBy('id', 'desc')
            ->paginate(100);
// return $articulos;
            // return redirect()->back()->withInput();
            return view('almacen.articulo.index', ["categorias" => $categorias,"tasaDolar" => $tasaDolar,"tasaPeso" => $tasaPeso,"tasaTransferenciaPunto" => $tasaTransferenciaPunto,"tasaMixto" => $tasaMixto,"tasaEfectivo" => $tasaEfectivo,"articulos" => $articulos,"oldCat" => $categorias_id,"name" => $name,"codigo" => $codigo,"venderal" => $venderal,"fechaInicio" => $fechaInicio,"fechaFin" => $fechaFin]);
        }
    }
    public function create()
    {
        $categorias = DB::table('categorias')->where('condicion', '=', 'Activa')->get();
        return view('almacen.articulo.create', ['categorias'=>$categorias]);
    }
    public function store(Request $request)
    {
        // return $request->all();
        //creamos un objeto del modelo categoria
        $articulo = new Articulo;
        $articulo->categoria_id  = $request->get('categoria_id');
        $articulo->codigo       = $request->get('codigo');
        $articulo->nombre       = $request->get('nombre');
        $articulo->stock         = 0;
        $articulo->unidades         = $request->get('unidades');
        $articulo->vender_al         = $request->get('vender_al');
        $articulo->precio_costo         = 0;
        $articulo->porEspecial         = $request->porEspecial;
        $articulo->isDolar         = $request->isDolar;
        $articulo->isPeso         = $request->isPeso;
        $articulo->isTransPunto         = $request->isTransPunto;
        $articulo->isMixto         = $request->isMixto;
        $articulo->isEfectivo         = $request->isEfectivo;
        $articulo->isKilo         = $request->isKilo;
        $articulo->descripcion  = $request->get('descripcion');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $file->move(public_path(). '/imagenes/articulos/', $file->getClientOriginalName('imagen'));
            $articulo->imagen   = $file->getClientOriginalName('imagen');
        }else{
            $articulo->imagen            = 'articulodefault.jpg';
        }

        $articulo->estado = 'Activo';

        $articulo->save();

        return Redirect::to('almacen/articulo')->with('status_success', 'Articulo registrado exitosamente');
    }


    public function show($id)
    {
        return view("almacen.articulo.show", ["articulo" => Articulo::findOrFail($id)]);
    }


    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = DB::table('categorias')->where('condicion', '=', 'Activa')->get();
        return view("almacen.articulo.edit", ["articulo" => $articulo, 'categorias'=> $categorias]);
    }
    public function update(Request $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->categoria_id  = $request->get('categoria_id');
        $articulo->codigo       = $request->get('codigo');
        $articulo->nombre       = $request->get('nombre');
        $articulo->precio_costo         = $request->get('precio_costo');
        $articulo->porEspecial         = $request->porEspecial;
        $articulo->isDolar         = $request->isDolar;
        $articulo->isPeso         = $request->isPeso;
        $articulo->isTransPunto         = $request->isTransPunto;
        $articulo->isMixto         = $request->isMixto;
        $articulo->isEfectivo         = $request->isEfectivo;
        $articulo->isKilo         = $request->isKilo;
        $articulo->descripcion  = $request->get('descripcion');
        $articulo->unidades         = $request->get('unidades');
        $articulo->vender_al         = $request->get('vender_al');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $file->move(public_path() . '/imagenes/articulos', $file->getClientOriginalName('imagen'));
            $articulo->imagen   = $file->getClientOriginalName('imagen');
        }

        $articulo->update();

        return Redirect::to('almacen/articulo')->with('status_success', 'El Artículo fue actualizado exitosamente');
    }
    public function destroy($id)
    {
        // dd('hola');
        $articulo = Articulo::findOrFail($id);
        $articulo->estado = 'Inactivo';
        $articulo->update();

        return redirect()
        ->route('articulo.index')
        ->with('status_success', 'El Artículo fue Eliminado exitosamente');

        // return Redirect::to('almacen/articulo')->with('El Artículo fue Eliminado exitosamente');
    }
}
