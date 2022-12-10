<?php

namespace App\Http\Controllers;

use App\Caja;
use App\User;
use App\Venta;
use App\Ingreso;
use App\Persona;
use App\Articulo;
use Carbon\Carbon;
use App\Articulo_venta;
use Illuminate\Http\Request;
use App\DetalleCreditoIngreso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ReporteController extends Controller
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
        // return $request->all();
        // $name = $request->get('name');
        $tipo = $request->get('tipo');
        // $description = $request->get('descripcion');
        $fecha = $request->get('fecha');
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');

        $fecha2 = $request->get('fecha2');

        // if($request){

        //     $categorias=Categoria::orderBy('id', 'DESC')
        //     ->name($name)
        //     ->condition($condition)
        //     ->description($description)
        //     ->fecha($fecha)
        //     ->get();
        //     return view("almacen.categoria.index",["categorias"=>$categorias]);
        // }

        $articulos = Articulo_venta::tipo($tipo)->fecha($fecha2)->paginate(10000);

        $title = 'Reporte de Productos Vendidos';
        $articulos = Articulo_venta::join('articulos', 'articulo_ventas.articulo_id', '=', 'articulos.id')
        ->join('ventas', 'articulo_ventas.venta_id', '=', 'ventas.id')
        ->where('ventas.estado', '=','Aceptada')
        // ->where('ventas.status', '=','Pagado')
        // ->name($name)
        ->tipo($tipo)
        // ->description($description)
        ->select('articulo_ventas.id','articulos.codigo','articulos.vender_al','articulos.nombre', 'articulos.porEspecial', 'articulos.isDolar', 'articulos.isPeso', 'articulos.isTransPunto', 'articulos.isMixto', 'articulos.isEfectivo','articulo_ventas.cantidad','articulo_ventas.precio_costo_unidad','articulo_ventas.precio_venta_unidad','articulo_ventas.descuento','articulo_ventas.created_at',DB::raw('sum(articulo_ventas.cantidad*articulo_ventas.precio_costo_unidad) as precio_costo_total'),DB::raw('sum(articulo_ventas.cantidad*articulo_ventas.precio_venta_unidad) as precio_venta_total'))
        ->fecha($fecha2)
        ->groupBy('articulo_ventas.id','articulos.codigo','articulos.vender_al','articulos.nombre', 'articulos.porEspecial', 'articulos.isDolar', 'articulos.isPeso', 'articulos.isTransPunto', 'articulos.isMixto', 'articulos.isEfectivo','articulo_ventas.cantidad','articulo_ventas.precio_costo_unidad','articulo_ventas.precio_venta_unidad','articulo_ventas.descuento','articulo_ventas.created_at')
        ->paginate(10000);

        // return $articulos;

        return view('reportes.ventas.index', ["title" => $title,"articulos" => $articulos,"fechaInicio" => $fechaInicio,"fechaFin" => $fechaFin]);
    }

    public function reportCalculoIndex(){
        
        $title = 'Calcular porcentaje de ventas';

        $users = User::where('id', '<>', '1')->Where('id', '<>', '2')->get();
        $proveedors = Persona::where('tipo_persona', '=', 'proveedor')->get();
        // $ingresos = Ingreso::get()
        // // ->name($name)
        // //     ->codigo($codigo)
        // //     ->venderal($venderal)
        //     ->fecha($fecha);

        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.porcentaje.index', compact('users','proveedors', 'title'));
    }

    public function reportCalculoShow(Request $request){
        // return $request;
        $fecha = $request->get('fecha');
        $estado = $request->get('estado');
        $proveedor = $request->get('proveedor');
        $operador = $request->get('operador');
        $operador = $request->get('operador');
        $title = 'Reporte de Ventas por Operador';
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');

        $fecha2 = $request->get('fecha2');

        if($fecha2 == null){
            $fechaData = $fecha;

        }else{
            $fechaData = $fecha2;
        }

       
        

        if ($operador) {
            $ventas_operador = Venta::select('id', 'user_id', 'serie_comprobante', 'total_venta', DB::raw('DATE(created_at) as date'))->where('estado', 'Aceptada')->where('status', 'Pagado')->fecha($fechaData)
            ->operador($operador)
            ->get()
            ->groupBy('date');

           
            $total_dia = [];
            $total_venta = [];
            $meta_alcanzada = [];
            $UnoPorCien = [];
            $CeroSesentaPorCien = [];
            $CeroCuarentaPorCien = [];
            $total_total_venta = 0;
            $total_UnoPorCien = 0;
            $total_CeroSesentaPorCien = 0;
            $total_CeroCuarentaPorCien = 0;
            foreach ($ventas_operador as $key => $value) {
                $usuario = [];
                $suma = 0;
                $sumados = 0;
                $total_comision = 0;
                
                foreach ($value as $b) {
                    if ($key == $b->date){
                        $suma +=  $b->total_venta;
                    }
                }
                
                $total_dia[] = $b->date;
                $total_venta[] = ROUND($suma,3);
                $meta_alcanzada[] = (ROUND($suma,3)) >= 500 ? 'Si' : 'No';
                $UnoPorCien[] = ($suma) >= 500 ? (ROUND($suma*0.01,3)) : 0.000;
                $CeroSesentaPorCien[] = (ROUND($suma,3)) < 500 ? (ROUND($suma*0.006,3)) : 0.000;
                $CeroCuarentaPorCien[] = (ROUND($suma,3)) < 500 ? (ROUND($suma*0.004,3)) : 0.000;
                $usuario[] = $value[0]->user->name;
                $total_total_venta += ROUND($suma ,3); 
                $total_UnoPorCien += ROUND($suma,3) >= 500 ? (ROUND($suma*0.01,3)) : 0.000;
                $total_CeroSesentaPorCien += (ROUND($suma,3)) < 500 ? (ROUND($suma*0.006,3)) : 0.000;
                $total_CeroCuarentaPorCien += (ROUND($suma,3)) < 500 ? (ROUND($suma*0.004,3)) : 0.000;
            }
            
        }else{
            $users = User::where('id', '<>', '1')->Where('id', '<>', '2')->get();

            foreach ($users as $user) {
                $ventas_operador = Venta::select('id', 'user_id', 'serie_comprobante', 'total_venta', DB::raw('DATE(created_at) as date'))->where('estado', 'Aceptada')->where('status', 'Pagado')->fecha($fechaData)
                ->where('user_id', $user->id)
                ->get()
                ->groupBy('date');


                $total_dia = [];
                $total_venta = [];
                $meta_alcanzada = [];
                $UnoPorCien = [];
                $CeroSesentaPorCien = [];
                $CeroCuarentaPorCien = [];
                $total_total_venta = 0;
                $total_UnoPorCien = 0;
                $total_CeroSesentaPorCien = 0;
                $total_CeroCuarentaPorCien = 0;

                foreach ($ventas_operador as $key => $value) {
                    $usuario = [];
                    $suma = 0;
                    $sumados = 0;
                    $total_comision = 0;
                    
                    foreach ($value as $b) {
                        if ($key == $b->date){
                            $suma +=  $b->total_venta;
                        }
                    }
                    
                    $total_dia[] = $b->date;
                    $total_venta[] = ROUND($suma,3);
                    $meta_alcanzada[] = (ROUND($suma,3)) >= 500 ? 'Si' : 'No';
                    $UnoPorCien[] = ($suma) >= 500 ? (ROUND($suma*0.01,3)) : 0.000;
                    $CeroSesentaPorCien[] = (ROUND($suma,3)) < 500 ? (ROUND($suma*0.006,3)) : 0.000;
                    $CeroCuarentaPorCien[] = (ROUND($suma,3)) < 500 ? (ROUND($suma*0.004,3)) : 0.000;
                    $usuario[] = $value[0]->user->name;
                    $total_total_venta += ROUND($suma ,3); 
                    $total_UnoPorCien += ROUND($suma,3) >= 500 ? (ROUND($suma*0.01,3)) : 0.000;
                    $total_CeroSesentaPorCien += (ROUND($suma,3)) < 500 ? (ROUND($suma*0.006,3)) : 0.000;
                    $total_CeroCuarentaPorCien += (ROUND($suma,3)) < 500 ? (ROUND($suma*0.004,3)) : 0.000;
                }                   
            }

            

           
            

        }
        
        $detallado = ($request->get('detallado') == 'on' ? '' : 'hidden');

        if($fechaData){
            list($fecha_inicio, $fecha_fin) = explode(" - ", $fechaData);
                $fecha_inicio = Carbon::parse($fecha_inicio)->format('d-m-Y');
                $fecha_fin = Carbon::parse($fecha_fin)->format('d-m-Y');

        }
        
        return view('reportes.porcentaje.show', compact('total_total_venta','total_UnoPorCien','total_CeroSesentaPorCien','total_CeroCuarentaPorCien','meta_alcanzada','UnoPorCien','CeroSesentaPorCien','CeroCuarentaPorCien','total_venta', 'usuario', 'total_dia', 'total_x_dia', 'ventas_operador', 'detallado','fecha_inicio','fecha_fin','fecha','estado','proveedor','operador', 'title'));
    }

    public function listadoInventario(){
        $title = 'Planilla de Inventario';
        $tasaDolar = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();
            $tasaPeso = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Peso')->first();
            $tasaTransferenciaPunto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Transferencia_Punto')->first();
            $tasaMixto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Mixto')->first();
            $tasaEfectivo = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Efectivo')->first();
            $articulos = DB::table('articulos as a')
            ->join('categorias as c', 'a.categoria_id', '=', 'c.id')

            ->select('a.id', 'a.codigo', 'a.nombre', 'a.stock', 'a.precio_costo', 'a.unidades', 'a.descripcion', 'a.imagen', 'a.estado', 'c.nombre as categoria')
            ->orderBy('id', 'desc')
            ->where('a.estado', 'Activo')
            ->get();
        // return $articulos;
        return view('reportes.inventario.listaInventario', compact('articulos','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaMixto','tasaEfectivo'));
    }

    public function listadoPrecio(){
        $title = 'Listado General de Precios';
        $tasaDolar = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();
            $tasaPeso = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Peso')->first();
            $tasaTransferenciaPunto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Transferencia_Punto')->first();
            $tasaMixto = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Mixto')->first();
            $tasaEfectivo = DB::table('tasas')->where('estado', '=', 'Activo')->where('nombre', '=', 'Efectivo')->first();
            $articulos = DB::table('articulos as a')
            ->join('categorias as c', 'a.categoria_id', '=', 'c.id')

            ->select('a.id', 'a.codigo', 'a.nombre', 'a.stock', 'a.precio_costo', 'a.unidades', 'a.descripcion', 'a.imagen', 'a.estado', 'a.porEspecial', 'a.isDolar', 'a.isPeso', 'a.isTransPunto', 'a.isMixto', 'a.isEfectivo', 'c.nombre as categoria')
            ->orderBy('id', 'desc')
            ->get();
        // return $articulos;
        return view('reportes.inventario.listaPrecio', compact('title','articulos','tasaDolar','tasaPeso','tasaTransferenciaPunto','tasaMixto','tasaEfectivo'));
    }

    public function reporteGeneral(){
        $title = 'Reporte General';
        $totalInversion = Articulo::where("estado","=",'Activo')
        ->select(DB::raw('sum(precio_costo*stock) as precio_costo_total'))
        ->get();

        $fecha_ultima_caja = Caja::where('estado','Cerrada')->orderBy('id', 'DESC')->first();
        // return $fecha_ultima_caja;
        $mayor = Articulo::where("estado","=",'Activo')
        ->where("vender_al","=",'Mayor')
        ->select(DB::raw('sum(precio_costo*stock) as totalMayor'),DB::raw('sum(unidades*stock) as totalUnidadesMayor'),DB::raw('sum(stock) as totalStockMayor'))
        ->get();

        $detal = Articulo::where("estado","=",'Activo')
        ->where("vender_al","=",'Detal')
        ->select(DB::raw('sum(precio_costo*stock) as totalDetal'),DB::raw('sum(unidades*stock) as totalUnidadesDetal'),DB::raw('sum(stock) as totalStockDetal'))
        ->get();
            $user = Auth::user();
        // return $totalInversion.$mayor.$detal;
        return view('reportes.inventario.general', compact('title', 'user','totalInversion','mayor','detal','fecha_ultima_caja'));
    }

    public function reportIngresosIndex(){

        $title = 'Reporte General de Compras por Fechas';

        $users = User::where('id', '<>', '1')->Where('id', '<>', '2')->get();
        $proveedors = Persona::where('tipo_persona', '=', 'proveedor')->get();
        // $ingresos = Ingreso::get()
        // // ->name($name)
        // //     ->codigo($codigo)
        // //     ->venderal($venderal)
        //     ->fecha($fecha);

        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.ingresos.index', compact('users','proveedors', 'title'));
    }

    public function reportIngresosShow(Request $request){
        // return $request;
        $fecha = $request->get('fecha');
        $estado = $request->get('estado');
        $proveedor = $request->get('proveedor');
        $operador = $request->get('operador');
        $title = 'Reporte General de Compras';
        $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');

            $fecha2 = $request->get('fecha2');

            if($fecha2 == null){
                $fechaData = $fecha;

            }else{
                $fechaData = $fecha2;
            }


        $ingresos = Ingreso::fecha($fechaData)
        ->estado($estado)
        ->proveedor($proveedor)
        ->operador($operador)
        ->get();

        if($fechaData){
            list($fecha_inicio, $fecha_fin) = explode(" - ", $fechaData);
                $fecha_inicio = Carbon::parse($fecha_inicio)->format('d-m-Y');
                $fecha_fin = Carbon::parse($fecha_fin)->format('d-m-Y');

        }


            $detallado = ($request->get('detallado') == 'on' ? '' : 'hidden');
        // ->name($name)
        //     ->codigo($codigo)
        //     ->venderal($venderal)


        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.ingresos.show', compact('detallado','fecha_inicio','fecha_fin','ingresos','fecha','estado','proveedor','operador', 'title'));
    }

    public function reportIngresosCreditosIndex(){
        

        $title = 'Reporte General de Compras a Credito por Fechas';

        $users = User::where('id', '<>', '1')->Where('id', '<>', '2')->get();
        $proveedors = Persona::where('tipo_persona', '=', 'proveedor')->get();
        // $ingresos = Ingreso::get()
        // // ->name($name)
        // //     ->codigo($codigo)
        // //     ->venderal($venderal)
        //     ->fecha($fecha);

        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.ingresos.credito.index', compact('users','proveedors', 'title'));
    }

    public function reportIngresosCreditosShow(Request $request){
        
        // return $request;
        $fecha = $request->get('fecha');
        $estado = $request->get('estado');
        $status = $request->get('status');
        $proveedor = $request->get('proveedor');
        $operador = $request->get('operador');
        $title = 'Reporte General de Compras a Creditos';
        $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');

            $fecha2 = $request->get('fecha2');

            if($fecha2 == null){
                $fechaData = $fecha;

            }else{
                $fechaData = $fecha2;
            }


        $ingresos = Ingreso::fecha($fechaData)
        ->estado($estado)
        ->status($status)
        ->proveedor($proveedor)
        ->operador($operador)
        ->where('tipo_pago','Credito')
        ->get();



        if($fechaData){
            list($fecha_inicio, $fecha_fin) = explode(" - ", $fechaData);
                $fecha_inicio = Carbon::parse($fecha_inicio)->format('d-m-Y');
                $fecha_fin = Carbon::parse($fecha_fin)->format('d-m-Y');

        }

        foreach ($ingresos as $ing) {
            $detalle_credito = DetalleCreditoIngreso::where('ingreso_id','=', $ing->id)
            ->select(DB::raw('sum(descuento) as descuento'),DB::raw('sum(incremento) as incremento'))
            ->first();
            // echo $detalle_credito;

            if($detalle_credito){
                $ingresos->descuento = $detalle_credito->descuento;
                $ingresos->incremento = $detalle_credito->incremento;
            }

        }




            $detallado = ($request->get('detallado') == 'on' ? '' : 'hidden');
        // ->name($name)
        //     ->codigo($codigo)
        //     ->venderal($venderal)


        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos->incremento;
        return view('reportes.ingresos.credito.show', compact('detallado','fecha_inicio','fecha_fin','ingresos','fecha','estado','proveedor','operador', 'title'));
    }


    public function reportClientesCreditosIndex(){
        
        $title = 'Reporte General de Ventas a Credito por Fechas';

        $users = User::where('id', '<>', '1')->Where('id', '<>', '2')->get();
        $proveedors = Persona::where('tipo_persona', '=', 'Cliente')->get();
        // $ingresos = Ingreso::get()
        // // ->name($name)
        // //     ->codigo($codigo)
        // //     ->venderal($venderal)
        //     ->fecha($fecha);

        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.clientes.credito.index', compact('users','proveedors', 'title'));
    }

    public function reportClientesCreditosShow(Request $request){
        // return 'si';
        // return $request;
        $fecha = $request->get('fecha');
        $estado = $request->get('estado');
        $status = $request->get('status');
        $proveedor = $request->get('proveedor');
        $operador = $request->get('operador');
        $title = 'Reporte General de Ventas a Credito';
        $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');

            $fecha2 = $request->get('fecha2');

            if($fecha2 == null){
                $fechaData = $fecha;

            }else{
                $fechaData = $fecha2;
            }


        $ingresos = Venta::fecha($fechaData)
        ->estado($estado)
        ->status($status)
        ->proveedor($proveedor)
        // ->operador($operador)
        ->where('tipo_pago_condicion','Credito')
        ->get();

        if($fechaData){
            list($fecha_inicio, $fecha_fin) = explode(" - ", $fechaData);
                $fecha_inicio = Carbon::parse($fecha_inicio)->format('d-m-Y');
                $fecha_fin = Carbon::parse($fecha_fin)->format('d-m-Y');

        }


            $detallado = ($request->get('detallado') == 'on' ? '' : 'hidden');
        // ->name($name)
        //     ->codigo($codigo)
        //     ->venderal($venderal)


        // foreach ($ingresos as $ing) {
        //     $ing->persona;
        //     $ing->user;
        //     foreach ($ing->articulo_ingresos as $art) {
        //         $art->articulo;
        //     }
        // }
// return $ingresos;
        return view('reportes.clientes.credito.show', compact('detallado','fecha_inicio','fecha_fin','ingresos','fecha','estado','proveedor','operador', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
