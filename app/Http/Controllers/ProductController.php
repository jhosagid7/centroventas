<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use DataTables;
use Redirect,Response;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
        $data = Articulo::latest()->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){

        $action = '<a class="btn btn-info" id="show-user" data-toggle="modal" data-id='.$row->id.'>Show</a>
        <a class="btn btn-success" id="edit-user" data-toggle="modal" data-id='.$row->id.'>Edit </a>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a id="delete-user" data-id='.$row->id.' class="btn btn-danger delete-user">Delete</a>';

        return $action;

        })
        ->rawColumns(['action'])
        ->make(true);
        }

        return view('almacen.product.index');
    }

    public function store(Request $request)
    {

        $r=$request->validate([
        'categoria_id' => 'categoria_id',
        'codigo' => 'codigo',
        'nombre' => 'nombre',
        'stock' => 'stock',
        'precio_costo' => 'precio_costo',
        'unidades' => 'unidades',
        'vender_al' => 'vender_al',
        'estado' => 'estado',

        ]);

        $uId = $request->user_id;
        Articulo::updateOrCreate(
            ['id' => $uId],
            [
            'categoria_id' => $request->categoria_id, 
            'codigo' => $request->codigo, 
            'nombre' => $request->nombre, 
            'stock' => $request->stock, 
            'precio_costo' => $request->precio_costo, 
            'unidades' => $request->unidades, 
            'vender_al' => $request->vender_al, 
            'estado' => $request->estado
            ]
        );
        if(empty($request->user_id))
        $msg = 'Articulo created successfully.';
        else
        $msg = 'Articulo data is updated successfully';
        return redirect()->route('product.index')->with('success',$msg);
    }

    
    public function show($id)
    {
        $where = array('id' => $id);
        $user = Articulo::where($where)->first();
        return Response::json($user);
        //return view('users.show',compact('user'));
    }

    
    public function edit($id)
    {
        $where = array('id' => $id);
        $user = Articulo::where($where)->first();
        return Response::json($user);
    }


    public function destroy($id)
    {
        // return $id;
        DB::statement("SET foreign_key_checks=0");

        $data = Articulo::where('id',$id)->delete();
        DB::statement("SET foreign_key_checks=1");
        return Response::json($data);
        // return redirect()->route('ariticulo.index');
    }
}
