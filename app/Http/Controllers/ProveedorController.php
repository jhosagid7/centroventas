<?php

namespace App\Http\Controllers;

use App\Persona;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('buscarTexto'));
            $personas = DB::table('personas')
                ->where('nombre', 'LIKE', '%' . $query . '%')
                ->where('tipo_persona', '=', 'Proveedor')
                ->orwhere('num_documento', 'LIKE', '%' . $query . '%')
                ->where('tipo_persona', '=', 'Proveedor')
                ->orderBy('id', 'desc')
                ->paginate(200);

            return view('compras.proveedor.index', ["personas" => $personas, "buscarTexto" => $query]);
        }
    }
    public function create()
    {
        return view('compras.proveedor.create');
    }
    public function store(PersonaFormRequest $request)
    {
        //creamos un objeto del modelo categoria
        $persona                    = new Persona;
        $persona->tipo_persona      = 'Proveedor';
        $persona->nombre            = $request->get('nombre');
        $persona->tipo_documento    = $request->get('tipo_documento');
        $persona->num_documento     = $request->get('num_documento');
        $persona->direccion         = $request->get('direccion');
        $persona->telefono          = $request->get('telefono');
        $persona->email             = $request->get('email');
        $persona->imagen            = 'thumb_upl_57e81d357d468.jpg';
        // if ($request->hasFile('imagen')) {
        //     $file = $request->file('imagen');
        //     $file->move(public_path(). '/imagenes/personas/', $file->getClientOriginalName('imagen'));
        //     $persona->imagen   = $file->getClientOriginalName('imagen');
        // }

        $persona->save();

        return Redirect::to('compras/proveedor')->with('status_success', 'El Proveedor fué registrado exitosamente');
    }
    public function show($id)
    {
        return view("compras.proveedor.show", ["persona" => Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("compras.proveedor.edit", ["persona" => Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request, $id)
    {
        $persona                    = Persona::findOrFail($id);
        $persona->nombre            = $request->get('nombre');
        $persona->tipo_documento    = $request->get('tipo_documento');
        $persona->num_documento     = $request->get('num_documento');
        $persona->direccion         = $request->get('direccion');
        $persona->telefono          = $request->get('telefono');
        $persona->email             = $request->get('email');
        $persona->imagen            = 'thumb_upl_57e81d357d468.jpg';
        // if ($request->hasFile('imagen')) {
        //     $file = $request->file('imagen');
        //     $file->move(public_path(). '/imagenes/personas/', $file->getClientOriginalName('imagen'));
        //     $persona->imagen   = $file->getClientOriginalName('imagen');
        // }

        $persona->update();

        return Redirect::to('compras/proveedor')->with('status_success', 'El Proveedor fué Actualizado exitosamente');
    }
    public function destroy($id)
    {
        $persona                = Persona::findOrFail($id);
        $persona->tipo_persona  = 'Inactivo';
        $persona->update();

        return Redirect::to('compras/proveedor');
    }
}
