<?php

namespace App\Http\Controllers;

use App\Persona;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // return 'soy index';
        if ($request) {
            $query = trim($request->get('buscarTexto'));
            $personas = DB::table('personas')
            ->where('nombre', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orwhere('num_documento', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orderBy('id', 'desc')
            ->get();

            return view('ventas.persona.index', ["personas" => $personas, "buscarTexto" => $query]);
        }
    }
    public function create()
    {
        return view('ventas.persona.create');
    }
    public function store(PersonaFormRequest $request)
    {
        //creamos un objeto del modelo categoria
        $persona = new Persona;
        $persona->tipo_persona = 'Cliente';
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->imagen            = 'thumb_upl_57e81d357d468.jpg';

        // if ($request->hasFile('imagen')) {
        //     $file = $request->file('imagen');
        //     $file->move(public_path(). '/imagenes/personas/', $file->getClientOriginalName('imagen'));
        //     $persona->imagen   = $file->getClientOriginalName('imagen');
        // }

        $persona->save();

        return Redirect::to('ventas/cliente')->with('status_success', 'El Cliente fué registrado exitosamente');
    }
    public function show($id)
    {
        return view("ventas.persona.show", ["persona" => Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("ventas.persona.edit", ["persona" => Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->imagen            = 'thumb_upl_57e81d357d468.jpg';

        // if ($request->hasFile('imagen')) {
        //     $file = $request->file('imagen');
        //     $file->move(public_path(). '/imagenes/personas/', $file->getClientOriginalName('imagen'));
        //     $persona->imagen   = $file->getClientOriginalName('imagen');
        // }

        $persona->update();

        return Redirect::to('ventas/cliente')->with('status_success', 'El Cliente fué Actualizado exitosamente');
    }
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo';
        $persona->update();

        return Redirect::to('ventas/cliente');
    }
}
