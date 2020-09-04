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


Route::get('/', 'TrackerController@save')->name('welcome');

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

    Route::post('/rechazarPedido/{idPedido}', 'PedidosController@rechazar')->name('pedido.rechazar');
});

#FACTURA PROFORMA
Route::get('/facturaProforma/{id}', 'FacturasController@show')->name('facturaProforma.show');

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
    Route::get('/generarUsuario/{id}', 'VendedoresController@createUser')->name('vendedor.generarUser');

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
//PRODUCTOS
Route::group(['middleware' => ['can:Productos_Gestionar']], function (){
    Route::get('/listaProductos', 'ProductosController@index')->name('productos.index');
    Route::get('/listaProductos/{id}', 'ProductosController@show')->name('productos.show');
    Route::get('/agregarProducto', 'ProductosController@create')->name('productos.create');
    Route::post('/agregarProducto', 'ProductosController@store')->name('productos.store');

    Route::get('/stockProductos', 'ProductosController@stockLote')->name('productos.stock');
    #workaround para ver mov Productos
    Route::get('/movimientoProductos', 'ProductosController@movProductos')->name('productos.movimiento');

});
//PRODUCTOS
Route::group(['middleware' => ['can:Productos_Gestionar']], function (){
    Route::get('/verPrecios', 'PreciosController@CargaMasivaCreate')->name('precios.create');
});
//PRECIOS
Route::group(['middleware' => ['can:Precios_Gestionar']], function (){
    Route::post('/cargaMasivaPrecios', 'PreciosController@cargaMasivaStore')->name('precios.cargaMasiva');
    Route::post('/cargaPrecio', 'PreciosController@productoIndividualStore')->name('precios.cargaProdIndividual');

    Route::get('/descargaExcelPrecios', 'PreciosController@descargaExcelPrecios')->name('precios.descargaExcelPrecios');
    Route::post('/cargaExcelPrecios', 'PreciosController@cargaExcelPrecios')->name('precios.cargaExcelPrecios');
});

//COMPRAS
Route::group(['middleware' => ['can:Compras_Gestionar']], function (){
    Route::get('/listaCompras', 'ComprasController@index')->name('compras.index');
    Route::get('/verCompra/{id}', 'ComprasController@show')->name('compras.show');
    Route::get('/agregarCompra', 'ComprasController@create')->name('compras.create');
    Route::post('/agregarCompra', 'ComprasController@store')->name('compras.store');
});

Route::group(['middleware' => ['role:Administracion']], function () {

    Route::get('/listaAjustes', 'AjustesInventarioController@index')->name('ajustes.index');
    Route::get('/agregarAjustes', 'AjustesInventarioController@create')->name('ajustes.create');
    Route::post('/agregarAjustes', 'AjustesInventarioController@store')->name('ajustes.store');
    Route::get('/verAjuste/{id}', 'AjustesInventarioController@show')->name('ajustes.show');
    Route::get('/ajusteAutomatico', 'AjustesInventarioController@storeProductosSinUnidades')->name('ajustes.automatico1');
    //Route::resource('/listaPedido', 'PedidosController@index');
    //Route::resource('roles', 'Admin\RolesController');
    //Route::resource('users', 'Admin\UsersController');
    //Route::get('login-activities',[
    //    'as' => 'login-activities',
    //    'uses' => 'Admin\UsersController@indexLoginLogs'
    //]);
});




