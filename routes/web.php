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


Route::get('/home', 'WorkflowController@ListaToDoUser')->name('home');


//PEDIDOS
Route::get('/listaPedidos', 'PedidosController@index')->name('pedido.index');
Route::get('/listaPedidos/{id}', 'PedidosController@show')->name('pedido.show');

Route::resource('AgregarPedidos', 'PedidosController@create');
Route::get('/agregarPedido/{idVendedor?}', 'PedidosController@create')->name('pedido.create');

Route::group(['middleware' => ['can:Pedidos_Clientes']], function (){
    Route::get('/seleccionarVendedor', 'PedidosController@createRouter')->name('pedido.createRouter');
});

Route::post('/agregarPedido', 'PedidosController@store')->name('pedido.store');
Route::post('/cargarProductos', 'PedidosController@cargarProductos')->name('cargarProductos.post');
Route::get('/editarPedido/{id?}', 'PedidosController@edit')->name('pedido.edit');

#ARMAR PEDIDO
Route::group(['middleware' => ['can:Pedidos_Armar']], function (){
    Route::get('/armarPedido/{idPedido}', 'PedidosController@armarPedidoCreate')->name('pedido.armar');
    Route::post('/armarPedido', 'PedidosController@armarPedidoStore')->name('armarPedido.store');
});
#VER CLIENTES
Route::group(['middleware' => ['can:Clientes_VerTodos']], function (){
    Route::get('/verClientes', 'VendedoresController@index')->name('vendedores.index');
    Route::get('/verCliente/{id}', 'VendedoresController@show')->name('vendedor.show');
});

#AGREGAR CLIENTE
Route::group(['middleware' => ['can:Clientes_Detalles']], function (){
    Route::get('/agregarVendedor', 'VendedoresController@create')->name('vendedores.create');
    Route::post('/agregarVendedor', 'VendedoresController@store')->name('vendedores.store');
    Route::get('/editarCliente/{id}', 'VendedoresController@edit')->name('vendedor.edit');
    Route::post('/editarCliente/{id}', 'VendedoresController@update')->name('vendedor.update');
});
#AGREGAR CREDITO AL CLIENTE
Route::group(['middleware' => ['can:Clientes_Credito']], function (){
    Route::get('/asignarCredito/{id?}', 'VendedoresController@createCredito')->name('vendedor.createCredito');
    Route::post('/asignarCredito', 'VendedoresController@storeCredito')->name('vendedor.creditoStore');
});
#AGREGAR DESCUENTO AL CLIENTE
Route::group(['middleware' => ['can:Clientes_Descuento']], function (){
    Route::get('/asignarDescuento/{id?}', 'VendedoresController@createDescuentos')->name('vendedor.createDescuento');
    Route::post('/asignarDescuento', 'VendedoresController@storeDescuento')->name('vendedor.descuentoStore');
});

Route::group(['middleware' => ['can:Productos_Gestionar']], function (){
    Route::get('/listaProductos', 'ProductosController@index')->name('productos.index');
    Route::get('/listaProductos/{id}', 'ProductosController@show')->name('productos.show');
    Route::get('/agregarProducto', 'ProductosController@create')->name('productos.create');
    Route::post('/agregarProducto', 'ProductosController@store')->name('productos.store');
});
//PRODUCTOS
Route::group(['middleware' => ['can:Productos_Gestionar']], function (){
    Route::get('/verPrecios', 'PreciosController@CargaMasivaCreate')->name('precios.create');
});
//PRECIOS
Route::group(['middleware' => ['can:Precios_Gestionar']], function (){
    Route::post('/cargaMasivaPrecios', 'PreciosController@cargaMasivaStore')->name('precios.cargaMasiva');
    Route::post('/cargaPrecio', 'PreciosController@productoIndividualStore')->name('precios.cargaProdIndividual');
});

//COMPRAS
Route::group(['middleware' => ['can:Compras_Gestionar']], function (){
    Route::get('/listaCompras', 'ComprasController@index')->name('compras.index');
    Route::get('/verCompra/{id}', 'ComprasController@show')->name('compras.show');
    Route::get('/agregarCompra', 'ComprasController@create')->name('compras.create');
    Route::post('/agregarCompra', 'ComprasController@store')->name('compras.store');
});

Route::group(['middleware' => ['role:Administracion']], function () {
    //Route::resource('/listaPedido', 'PedidosController@index');
    //Route::resource('roles', 'Admin\RolesController');
    //Route::resource('users', 'Admin\UsersController');
    //Route::get('login-activities',[
    //    'as' => 'login-activities',
    //    'uses' => 'Admin\UsersController@indexLoginLogs'
    //]);
});




