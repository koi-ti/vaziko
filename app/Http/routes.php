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
	
	Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index']]);

	Route::resource('actividades', 'Admin\ActividadController', ['only' => ['index']]);
	
	Route::group(['prefix' => 'terceros'], function()
	{
		Route::get('dv', ['as' => 'terceros.dv', 'uses' => 'Admin\TerceroController@dv']);
		Route::get('rcree', ['as' => 'terceros.rcree', 'uses' => 'Admin\TerceroController@rcree']);

		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index']]);
	});	
	Route::resource('terceros', 'Admin\TerceroController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);

	Route::resource('plancuentas', 'Accounting\PlanCuentasController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('centroscosto', 'Accounting\CentroCostoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
});
