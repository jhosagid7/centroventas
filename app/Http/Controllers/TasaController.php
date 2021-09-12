<?php

namespace App\Http\Controllers;

use App\Tasa;
use Illuminate\Http\Request;

class TasaController extends Controller
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
        $title='Crear Tasa o Margen de ganancia';
        $tasas = Tasa::get();

        return view('ventas.tasa.index', compact('title','tasas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasas = Tasa::get();
        $title='Actualizar tasa';

        return view('ventas.tasa.create', compact('title','tasas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return 'store';
    //    return $request->id;
    //     $request->validate([
    //         'nombre'                 => 'required|max:20',
    //         'tasa'                   => 'required',
    //         'porcentaje_ganancia'    => 'required',
    //         'estado'                 => 'required'
    //     ]);

            $id = $request->get('id');
            $url = $request->get('url');
            $tasa = $request->get('tasa');
            $porcentaje_ganancia = $request->get('porcentaje');

            //hacemos truncate a las tablas que tienen modelos pero con eloquent
            // Tasa::truncate();

            //creamos un contador
            $cont = 0;
         //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
         while ($cont < count($id)) {
            $idtasa = $id[$cont];
            $Ntasa = Tasa::findOrFail($idtasa);
            $Ntasa->id = $id[$cont];//este idingreso se autogenera cuando se crea el objeto en la parte superior (*)
            $Ntasa->tasa = $tasa[$cont];
            $Ntasa->porcentaje_ganancia = $porcentaje_ganancia[$cont];

            $Ntasa->update();

            $cont = $cont+1;
        }

        return redirect($url)
        ->with('status_success', 'Tasa creada exitosamente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crearTasas(Request $request)
    {
        return 'estoy en creartasas';
        // $request->validate([
        //     'nombre'                 => 'required|max:20',
        //     'tasa'                   => 'required',
        //     'porcentaje_ganancia'    => 'required',
        //     'estado'                 => 'required'
        // ]);

        // //llenamos la variable $role para luego guardarla
        // $role = Tasa::create($request->all());


        // return redirect()
        // ->route('tasa.index')
        // ->with('status_success', 'Tasa creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'este des show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $this->authorize('update', [$user, ['user.edit', 'userown.edit']]);
        $title='Editar Tasa';

        $tasa = Tasa::find($id);
        // return $roles;
        return view('ventas.tasa.edit', compact('title', 'tasa', 'tasas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $request;
        $title='Crear Tasa o Margen de ganancia';
        $tasa = Tasa::find($id);
        $tasa->tasa = $request->tasa;
        $tasa->porcentaje_ganancia = $request->porcentaje_ganancia;
        $tasa->estado = $request->estado;
        $tasa->caja = 'Abierta';
        $tasa->save();
        return redirect()
        ->route('tasa.index')
        ->with('status_success', 'Role saved successfully');
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
    //Actualizar un solo registro
    // $app = ModelName::find($id);
    // $app->name = $request->name;
    // $app->email = $request->email;
    // $save();

    //Actualizar con base en una condición
    // $app = App\ModelName::find(1);
    // $app->where("status", 1)
    // ->update(["keyOne" => $valueOne, "keyTwo" => $valueTwo]);
}
