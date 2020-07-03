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
Route::get('/agregarPedido/{param?}', 'PedidosController@create')->name('pedido.create');
Route::get('/seleccionarVendedor', 'PedidosController@createAdmin')->name('pedido.createAdmin');
Route::post('/agregarPedido', 'PedidosController@store')->name('pedido.store');
Route::post('/cargarProductos', 'PedidosController@cargarProductos')->name('cargarProductos.post');



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




