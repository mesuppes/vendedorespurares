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
use App\Tracker;

Route::get('/', function () {

    //number of user connected or viewed
    Tracker::firstOrCreate([
        'ip'   => $_SERVER['REMOTE_ADDR']],
        ['ip'   => $_SERVER['REMOTE_ADDR'],
        'current_date' => date('Y-m-d')])->save();

    return view('welcome');
})->name('welcome');

Route::group(['middleware' => ['role:admin']], function () {
	Route::resource('permissions', 'Admin\PermissionsController');
    Route::resource('roles', 'Admin\RolesController');
    Route::resource('users', 'Admin\UsersController');
    Route::get('login-activities',[
        'as' => 'login-activities',
        'uses' => 'Admin\UsersController@indexLoginLogs'
    ]);
});

Route::group(['middleware' => ['role:user']], function () {

});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('profile','Users\ProfileController');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


//PEDIDOS


Route::get('/listaPedidos', 'PedidosController@index')->name('pedido.index');
Route::get('/listaPedidos/{id}', 'PedidosController@show')->name('pedido.show');
Route::get('/agregarPedido/{idVendedor?}', 'PedidosController@create')->name('pedido.create');
Route::get('/seleccionarVendedor', 'PedidosController@createRouter')->name('pedido.createRouter');
Route::post('/agregarPedido', 'PedidosController@store')->name('pedido.store');
Route::post('/cargarProductos', 'PedidosController@cargarProductos')->name('cargarProductos.post');
Route::get('/editarPedido/{id?}', 'PedidosController@edit')->name('pedido.edit');
Route::get('/armarPedido/{idPedido}', 'PedidosController@armarPedidoCreate')->name('pedido.armar');
Route::post('/armarPedido', 'PedidosController@armarPedidoStore')->name('armarPedido.store');
Route::get('/asignarCredito/{id?}', 'VendedoresController@createCredito')->name('vendedor.createCredito');
Route::post('/asignarCredito', 'VendedoresController@storeCredito')->name('vendedor.creditoStore');
Route::get('/asignarDescuento/{id?}', 'VendedoresController@createDescuentos')->name('vendedor.createDescuento');
Route::post('/asignarDescuento', 'VendedoresController@storeDescuento')->name('vendedor.descuentoStore');
Route::get('/listaProductos', 'ProductosController@index')->name('productos.index');
Route::get('/listaProductos/{id}', 'ProductosController@show')->name('productos.show');
Route::get('/agregarProducto', 'ProductosController@create')->name('productos.create');
Route::post('/agregarProducto', 'ProductosController@store')->name('productos.store');
Route::get('/verPrecios', 'PreciosController@CargaMasivaCreate')->name('precios.create');
Route::post('/cargaMasivaPrecios', 'PreciosController@cargaMasivaStore')->name('precios.cargaMasiva');
Route::post('/cargaPrecio', 'PreciosController@productoIndividualStore')->name('precios.cargaProdIndividual');


Route::group(['middleware' => ['role:Administracion']], function () {
    Route::resource('AgregarPedidos', 'PedidosController@create');
    //Route::resource('/listaPedido', 'PedidosController@index');
    //Route::resource('roles', 'Admin\RolesController');
    //Route::resource('users', 'Admin\UsersController');
    //Route::get('login-activities',[
    //    'as' => 'login-activities',
    //    'uses' => 'Admin\UsersController@indexLoginLogs'
    //]);
});




