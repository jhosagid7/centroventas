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

Route::resource('/role', 'RoleController')->names('role');

Route::resource('/user', 'UserController', ['except'=>[
    'create', 'store'
]])->names('user');


Route::resource('almacen/categoria', 'CategoriaController');
Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('compras/credito', 'DetalleCreditoIngresoController');
Route::resource('ventas/creditos', 'DetalleCreditoVentaController');
// Route::resource('credito-ver', 'DetalleCreditoIngresoController@ver');
Route::resource('ventas/venta', 'VentaController');

Route::resource('pagos/categorias', 'CategoriaPagoController');
Route::resource('pagos/tipo', 'TipoPagoController');


Route::resource('pagos/servicios', 'ServicioController');
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
Route::get('/servicios', 'ServicioController@getServiciosOrigenes')->name('servicios');


Route::resource('reportes/ventas', 'ReporteController');
// Route::resource('reportes/ventas', 'ReporteController');

Route::get('/inventario', 'ReporteController@listadoInventario')->name('inventario');
Route::get('/precios', 'ReporteController@listadoPrecio')->name('precios');
Route::get('/reporte-general', 'ReporteController@reporteGeneral')->name('reporte-general');
Route::get('/reporte-ingreso', 'ReporteController@reportIngresosIndex')->name('reporte-ingreso');
Route::get('/reporte-compras', 'ReporteController@reportIngresosShow')->name('reporte-compras');
Route::get('/reporte-ingreso-creditos', 'ReporteController@reportIngresosCreditosIndex')->name('reporte-ingreso-creditos');
Route::get('/reporte-compra-creditos', 'ReporteController@reportIngresosCreditosShow')->name('reporte-compra-creditos');

Route::get('/reporte-credito-clientes', 'ReporteController@reportClientesCreditosIndex')->name('reporte-credito-clientes');
Route::get('/reporte-credito-clientes-ver', 'ReporteController@reportClientesCreditosShow')->name('reporte-credito-clientes-ver');


Route::resource('/cargos', 'CargoController', ['except'=>[
    'edit', 'update'
    ]])->names('cargo');

Route::resource('/descargos', 'DescargoController', ['except'=>[
        'edit', 'update'
        ]])->names('descargo');

Route::get('/ventas/consulta', 'ConsultaController@precioVenta')->name('consulta');
Route::resource('/bancos/banco', 'BancoController');

Route::get('datatable/ventas', 'DatatableController@ventas')->name('datatable.venta');

Route::get('search/articulos', 'SearchController@articulos')->name('search.articulos');
Route::get('search/articulos/ventas', 'SearchController@articulosVentas')->name('search.articulos.ventas');
Route::get('search/articulos/cargos', 'SearchController@articulosCargos')->name('search.articulos.cargos');

//Creamos rutas para la Impresion de tickets
Route::get('print/venta/{$id}','PrinterController@ticketVenta');
// Route::get('print/credito-pagado/{$id}','PrinterController@ticketCreditoPagado');
