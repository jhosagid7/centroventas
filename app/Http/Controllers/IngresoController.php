<?php

namespace App\Http\Controllers;

use DB;

use Response;
use App\Ingreso;
use App\Articulo;
use Carbon\Carbon;
use App\DetalleVenta;
use App\Http\Requests;
use App\DetalleIngreso;
use App\Articulo_Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Input;
//use Illuminate\Http\Response;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\IngresoFormRequest;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $title='Ingresos';
            // $query = trim($request->get('buscarTexto'));
            $ingresos = DB::table('ingresos as i')
                ->join('personas as p', 'i.persona_id', '=', 'p.id')
                ->join('users as u', 'i.user_id', '=', 'u.id')
                ->join('articulo__ingresos as ai', 'i.id', '=', 'ai.ingreso_id')
                ->select('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado', DB::raw('sum(ai.cantidad*precio_costo_unidad) as total'))
                // ->where('i.num_comprobante', 'LIKE', '%'. $query  .'%')
                ->orderBy('i.id', 'desc')
                ->groupBy('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado')
                ->get();

            return view('compras.ingreso.index', ["title"=>$title,"ingresos" => $ingresos]);
        }
    }

    public function create()
    {
        $personas = DB::table('personas')->where('tipo_persona', '=', 'Proveedor')->get();
        $articulos = DB::table('articulos as art')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.id', 'art.precio_costo')
            ->where('art.estado', '=', 'Activo')
            ->get();

        return view('compras.ingreso.create', ["personas" => $personas, "articulos" => $articulos]);
    }

    public function store(IngresoFormRequest $request)
    {
        // return $request->all();

        try{
            DB::beginTransaction();
            $ingreso = new Ingreso; //(*) al guardar genera un idingreso automatimanente que luego se usa en la tabla detalle
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $ingreso->precio_compra = $request->get('total');


            $myTime = Carbon::now('America/Caracas');
            $ingreso->fecha_hora = $myTime->toDateTimeString();
            $ingreso->estado = 'Aceptado';
            $ingreso->persona_id = $request->get('idproveedor');
            $ingreso->user_id = $request->user()->id;
            // return $request->user()->id;
            $ingreso->save();

            //cargamos los datos del detalle del ingreso en unas variables que reciven
            //un array

            $articulo_id = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_costo_unidad = $request->get('precio_compra');


            //creamos un contador
            $cont = 0;

            //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
            while ($cont < count($articulo_id)) {

                $Articulo_Ingreso = new Articulo_Ingreso();
                $Articulo_Ingreso->cantidad = $cantidad[$cont];
                $Articulo_Ingreso->precio_costo_unidad = $precio_costo_unidad[$cont];
                $Articulo_Ingreso->ingreso_id = $ingreso->id;
                $Articulo_Ingreso->articulo_id = $articulo_id[$cont];
                $Articulo_Ingreso->save();

                $cont = $cont+1;
            }

            DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            // dd($e);
        }

        return Redirect::to('compras/ingreso')->with('success', 'El Ingreso fué registrado exitosamente');
    }

    public function show($id)
    {
        $title = 'Reporte de Ingreso';

        $ingreso = DB::table('ingresos as i')
                ->join('personas as p', 'i.persona_id', '=', 'p.id')
                ->join('users as u', 'i.user_id', '=', 'u.id')
                ->join('articulo__ingresos as ai', 'i.id', '=', 'ai.ingreso_id')
                ->select('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado', DB::raw('sum(ai.cantidad*precio_costo_unidad) as total'))
                ->where('i.id', '=', $id)
                ->orderBy('i.id', 'desc')
                ->groupBy('i.id', 'u.name', 'i.fecha_hora', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.telefono', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado')
                ->get();

        //traemos los datos de la tabla detalle_articulos
        $Articulo_Ingresos = DB::table('articulo__ingresos as ai')
            ->join('articulos as a', 'ai.articulo_id', '=', 'a.id')
            ->select('a.nombre as articulo', 'ai.cantidad', 'ai.precio_costo_unidad')
            ->where('ai.ingreso_id', '=', $id)->get();

            // return $ingreso;

        return view("compras.ingreso.show", ["title" => $title, "ingreso" => $ingreso, "Articulo_Ingresos"=> $Articulo_Ingresos]);
    }

    public function destroy($id)
    {
        try{
            DB::beginTransaction();
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'Cancelado';
        $ingreso->update();

        $detalleIngreso = Articulo_Ingreso::where('ingreso_id','=',$id)->get();

         //creamos un contador
         $cont = 0;

         //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
         while ($cont < count($detalleIngreso)) {
            $idarticulo = $detalleIngreso[$cont]->articulo_id;
            $articulo = Articulo::findOrFail($idarticulo);
            $articulo->stock = $articulo->stock-$detalleIngreso[$cont]->cantidad;
            $articulo->update();

            $cont = $cont+1;

         };
         DB::commit();

        }catch(\Exception $e)
        {

            DB::rollback();
            dd($e);
        }

        return Redirect::to('compras/ingreso');
    }

    public function exportToPDF(){
        $ingresos = Ingreso::get();
        $pdf = PDF::loadView('compras.ingreso.exportToPdf', Compact('ingresos'));
        $pdf->setPaper('a4', 'landscape');

        // $order          = Order::find($id);
        // $customer       = Customer::find($order->customer_id);
        // $shipping       = Shipping::find($order->shipping_id);
        // $orderDetails   = OrderDetail::where('order_id', $order->id)->get();

        // $pdf = PDF::loadView('admin.order.download-invoice',[
        //     'order'=> $order,
        //     'customer'=>$customer,
        //     'shipping'=>$shipping,
        //     'orderDetails'=>$orderDetails
        // ]);

        // return $pdf->download('invoice.pdf');
//        return $pdf->stream('invoice.pdf');
        return $pdf->download('ListadoIngresos.pdf');
    }
}
