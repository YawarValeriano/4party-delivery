<?php

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
    return redirect('escritorio/inicio');
});
Route::get('/escritorio/inicio', 'InicioController@index');

Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('ventas/venta','VentaController');
Route::resource('seguridad/usuario','UsuarioController');

Route::auth();

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('Descargar Articulos', 'ArticuloController@downloadPDF')->name('articulo');
/*Route::get('Descargar Ingresos', 'IngresoController@ingreso_pdf')->name('ingresos.pdf');
Route::get('Descargar Ventas', 'VentaController@venta_pdf')->name('ventas.pdf');
Route::get('Descargar Detalle_Ingreso', 'IngresoController@ingreso_pdf')->name('det_ingresos.pdf');
Route::get('Descargar Detalle_Venta', 'VentaController@venta_pdf')->name('det_ventas.pdf');*/
Route::get('/info', 'InfoController@index');
