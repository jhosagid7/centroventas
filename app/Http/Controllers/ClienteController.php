<?php

namespace App\Http\Controllers;

use App\Venta;

use App\Persona;
use Carbon\Carbon;
use App\Http\Requests;
use App\ClienteCredito;
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

        // return $request->isCortesia;;
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
        $persona->isCortesia            = $request->isCortesia;
        $persona->isCredito            = $request->isCredito;
        $persona->limite_fecha            = $request->get('limite_fecha');
        $persona->limite_monto            = $request->get('limite_monto');

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
        $persona = Persona::findOrFail($id);
        if($persona){

            $persona_credito = ClienteCredito::where('persona_id', $id)->first();
            if($persona_credito){
                $persona->cliente_creditos = $persona->cliente_creditos[0]->estado_credito;

                $creditos_vencidos = Venta::where('tipo_pago_condicion', 'Credito')->where('status', 'Pendiente')->where('persona_id', $id)->get();
                // return $creditos_vencidos;
                if ($creditos_vencidos) {


                    foreach ($creditos_vencidos as $credVencido) {
                        $date = Carbon::now('America/Caracas');
                        $now = Carbon::parse($date);
                        $second = $credVencido->created_at;
                        $addFecha = $second->addDay($credVencido->Persona->limite_fecha);
                        // return $now . ' '. $second . ' ' . $addFecha . ' - ' . $credVencido->created_at;

                        if ($now->gte($addFecha)) {
                            // return 'tiene credito vencido';
                            $credito_id = $credVencido->id;
                            $upCredito = Venta::findOrFail($credito_id);

                            $upCredito->estado_credito = 'Vencido';
                            $upCredito->update();

                            $cliente_moroso = ClienteCredito::where('persona_id', $credVencido->persona_id)->first();

                            if ($cliente_moroso->total_deuda > 0) {
                                $cliente_moroso->estado_credito = 'Moroso';
                                $cliente_moroso->update();

                                $persona->credito_vencido = 1;
                            }else{
                                $cliente_moroso->estado_credito = 'Activo';
                                $cliente_moroso->update();

                                $persona->credito_vencido = 0;
                            }

                        }

                    }
                }
            }else{
                $persona->cliente_creditos = 'No tiene credito';
                $persona->credito_vencido = 'No aplica';
            }


        }


        // return $p->cliente_creditos[0]->estado_credito;
        return view("ventas.persona.edit", compact('persona'));
    }
    public function update(PersonaFormRequest $request, $id)
    {
        // return $request;
        $persona = Persona::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->imagen            = 'thumb_upl_57e81d357d468.jpg';
        $persona->isCortesia            = $request->isCortesia;
        $persona->isCredito            = $request->isCredito;
        $persona->limite_fecha            = $request->get('limite_fecha');
        $persona->limite_monto            = $request->get('limite_monto');

        // if ($request->hasFile('imagen')) {
        //     $file = $request->file('imagen');
        //     $file->move(public_path(). '/imagenes/personas/', $file->getClientOriginalName('imagen'));
        //     $persona->imagen   = $file->getClientOriginalName('imagen');
        // }

        $persona->update();

        if($request->get('facturas_vencidas_comparar') != 'No tiene credito'){
            // return 'se puede guardar';
            $cliente = ClienteCredito::where('persona_id', $id)->first();
            $cliente->estado_credito = $request->get('estado_credito');
            $cliente->update();
        }

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
