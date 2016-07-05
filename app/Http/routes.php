<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Routes Auth
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function()
{
	Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
	Route::get('integrate', ['as' => 'auth.integrate', 'uses' => 'Auth\AuthController@integrate']);
});
Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);

/*
|--------------------------------------------------------------------------
| Secure Routes Application
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);
	/*
	|-------------------------
	| Admin Routes
	|-------------------------
	*/	
	Route::group(['prefix' => 'terceros'], function()
	{
		Route::get('dv', ['as' => 'terceros.dv', 'uses' => 'Admin\TerceroController@dv']);
		Route::get('rcree', ['as' => 'terceros.rcree', 'uses' => 'Admin\TerceroController@rcree']);
		Route::get('search', ['as' => 'terceros.search', 'uses' => 'Admin\TerceroController@search']);
                
		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index']]);
	});	
	Route::resource('terceros', 'Admin\TerceroController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
    Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index', 'show']]);
	Route::resource('actividades', 'Admin\ActividadController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('empresa', 'Admin\EmpresaController', ['only' => ['index', 'update']]);
        
	/*
	|-------------------------
	| Accounting Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'plancuentas'], function()
	{
		Route::get('nivel', ['as' => 'plancuentas.nivel', 'uses' => 'Accounting\PlanCuentasController@nivel']);
		Route::get('search', ['as' => 'plancuentas.search', 'uses' => 'Accounting\PlanCuentasController@search']);
	});
    Route::resource('plancuentas', 'Accounting\PlanCuentasController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);

	Route::group(['prefix' => 'documentos'], function()
	{
		Route::get('filter', ['as' => 'documentos.filter', 'uses' => 'Accounting\DocumentoController@filter']);
	});
	Route::resource('documentos', 'Accounting\DocumentoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
        
	Route::group(['prefix' => 'asientos'], function()
	{
		Route::resource('detalle', 'Accounting\DetalleAsientoController', ['only' => ['index', 'store']]);
	});
	Route::resource('asientos', 'Accounting\AsientoController', ['only' => ['index', 'create', 'store', 'show']]);
	
	Route::resource('centroscosto', 'Accounting\CentroCostoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
   	Route::resource('folders', 'Accounting\FolderController', ['only'=>['index', 'create', 'store', 'edit', 'update', 'show']]);
});
