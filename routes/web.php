<?php

use App\User;

use App\Ingreso;
use App\Articulo;
use App\Articulo_Ingreso;
use App\Permission\Models\Role;
// use Facade\FlareClient\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => true
]);

Route::get('/home', 'VentaController@index')->name('home');



Route::get('/test', function () {
    // $user = User::find(2);

    //$user->roles()->sync([2]);
    // return $user->roles;
    // return $user->havePermission('role.create');
    // Gate::authorize('haveaccess', 'role.index');
    // $caja =  App\Caja::where('estado', 'Abierta')->orderBy('id', 'desc')->first();

    // $tasa = App\Tasa::find(1);
    // $tasa->updated_at;
    // $fechaActual = Carbon\Carbon::now();

    // if ($tasa->updated_at->diffInHours($fechaActual) >= 3 ) {
    //     return 'Debes actualizar el margen de ganancia';
    // }else{
    //     return 'Puedes continuar';
    // }

    // $detalleingresos = Articulo_Ingreso::get();
    // $detalleingresos->ingreso;
    // $ingreso = Ingreso::get();

    // foreach ($ingreso as $ing) {
    //     $ing->persona;
    //     $ing->user;
    //     // $ing->articulo_ingresos;
    //     foreach ($ing->articulo_ingresos as $art) {
    //         $art->articulo;
    //     }


    // }
    // $venderAlDetal = Articulo::activo()->get();

    // $haystack = ['Caja de arros Juana','Caja de arros primor'];
    // foreach ($haystack as $key) {
    //     $dato = Str::contains($key,'arros maria');
    //     if (isset($dato) && $dato == 1) {
    //         $valor = $key;
    //     }else{
    //         $valor = 'No hay datos relacionados';
    //     }

    // }
    //     $url = "https://dolartoday.com/api/";
    //     $cliente = new GuzzleHttp\Client;
    //     // $valor = HTTP::get($url)->json();
    //     $response = $cliente->get($url);

    //  var_dump($response->getBody()->getContents());


});

// Route::get('/test', function () {
//     $user = User::find(2);
//     $empre = App\Empresa::orderBy('id','Desc')->get();
//     $empresa = App\Empresa::find(1)->cajas()->orderBy('nombre')->get();
//     $cajas = App\Sucursal::find(1)->cajas()->orderBy('nombre')->get();
//     $tasa1 = App\Tasa::get();
//     $tasa2 = App\Empresa::orderBy('id','Desc')->get();
//     $tasa1 = App\Tasa::get();
//     $tasa = App\Tasa::find(1);


//     return $tasa;
// });

Route::resource('/role', 'RoleController')->names('role');

Route::resource('/user', 'UserController', ['except'=>[
    'create', 'store'
]])->names('user');


Route::resource('almacen/categoria', 'CategoriaController');
Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('ventas/venta', 'VentaController');




Route::resource('ventas/tasa', 'TasaController');
Route::resource('almacen/transferencia', 'TransferenciaController', ['except'=>[
    'edit', 'update', 'destroy'
]]);
Route::resource('cajas/caja', 'CajaController');

Route::get('listarcaja', 'cajaController@listarcaja')->name('listarcaja');

// Route::get('ventas/tasa', 'TasaController@crearTasas')->name('creartasas');

Route::get('/ingreso/exportToPDF','IngresoController@exportToPDF')->name('pdf');
Route::get('/cajas/caja/{caja}/print ','CajaController@print')->name('print');

Route::get('/origen', 'TransferenciaController@getProductoOrigenes')->name('origen');
Route::get('/destino', 'TransferenciaController@getProductoDestinos')->name('destino');

Route::resource('reportes/ventas', 'ReporteController');
// Route::resource('reportes/ventas', 'ReporteController');

Route::get('/inventario', 'ReporteController@listadoInventario')->name('inventario');
Route::get('/precios', 'ReporteController@listadoPrecio')->name('precios');
Route::get('/reporte-general', 'ReporteController@reporteGeneral')->name('reporte-general');
Route::get('/reporte-ingreso', 'ReporteController@reportIngresosIndex')->name('reporte-ingreso');
Route::get('/reporte-compras', 'ReporteController@reportIngresosShow')->name('reporte-compras');


Route::resource('/cargos', 'CargoController', ['except'=>[
    'edit', 'update'
    ]])->names('cargo');

Route::resource('/descargos', 'DescargoController', ['except'=>[
        'edit', 'update'
        ]])->names('descargo');

Route::get('/ventas/consulta', 'ConsultaController@precioVenta')->name('consulta');
