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
		Route::get('facturap', ['as' => 'terceros.facturap', 'uses' => 'Admin\TerceroController@facturap']);

		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index', 'store', 'update']]);
	});
	Route::resource('terceros', 'Admin\TerceroController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('empresa', 'Admin\EmpresaController', ['only' => ['index', 'update']]);
    Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('actividades', 'Admin\ActividadController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index', 'show']]);
	Route::resource('sucursales', 'Admin\SucursalController', ['except' => ['destroy']]);
	Route::resource('puntosventa', 'Admin\PuntoVentaController', ['except' => ['destroy']]);

	Route::resource('roles', 'Admin\RolController', ['except' => ['destroy']]);

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
		Route::resource('detalle', 'Accounting\DetalleAsientoController', ['only' => ['index', 'store', 'destroy']]);
		Route::get('exportar/{asientos}', ['as' => 'asientos.exportar', 'uses' => 'Accounting\AsientoController@exportar']);

		Route::group(['prefix' => 'detalle'], function()
		{
			Route::post('evaluate', ['as' => 'asientos.detalle.evaluate', 'uses' => 'Accounting\DetalleAsientoController@evaluate']);
			Route::post('validate', ['as' => 'asientos.detalle.validate', 'uses' => 'Accounting\DetalleAsientoController@validation']);
			Route::get('movimientos', ['as' => 'asientos.detalle.movimientos', 'uses' => 'Accounting\DetalleAsientoController@movimientos']);
		});
	});
	Route::resource('asientos', 'Accounting\AsientoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);

	Route::resource('centroscosto', 'Accounting\CentroCostoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
   	Route::resource('folders', 'Accounting\FolderController', ['only'=>['index', 'create', 'store', 'edit', 'update', 'show']]);

   	/*
	|-------------------------
	| Supplier invoice Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'facturap'], function()
	{
		Route::get('search', ['as' => 'facturap.search', 'uses' => 'Accounting\FacturapController@search']);
		Route::resource('cuotas', 'Accounting\FacturapCuotasController', ['only' => ['index']]);
	});
	Route::resource('facturap', 'Accounting\FacturapController', ['only' => ['index']]);

	/*
	|-------------------------
	| Production Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'ordenes'], function()
	{
		Route::get('search', ['as' => 'ordenes.search', 'uses' => 'Production\OrdenpController@search']);
		Route::get('exportar/{ordenes}', ['as' => 'ordenes.exportar', 'uses' => 'Production\OrdenpController@exportar']);
		Route::get('cerrar/{ordenes}', ['as' => 'ordenes.cerrar', 'uses' => 'Production\OrdenpController@cerrar']);
		Route::get('abrir/{ordenes}', ['as' => 'ordenes.abrir', 'uses' => 'Production\OrdenpController@abrir']);
		Route::get('clonar/{ordenes}', ['as' => 'ordenes.clonar', 'uses' => 'Production\OrdenpController@clonar']);

		Route::get('productos/formula', ['as' => 'ordenes.productos.formula', 'uses' => 'Production\DetalleOrdenpController@formula']);

		Route::group(['prefix' => 'productos'], function()
		{
			Route::get('clonar/{productos}', ['as' => 'ordenes.productos.clonar', 'uses' => 'Production\DetalleOrdenpController@clonar']);

			Route::resource('maquinas', 'Production\DetalleMaquinasController', ['only' => ['index']]);
			Route::resource('materiales', 'Production\DetalleMaterialesController', ['only' => ['index']]);
			Route::resource('acabados', 'Production\DetalleAcabadosController', ['only' => ['index']]);
		});
		Route::resource('productos', 'Production\DetalleOrdenpController');

		Route::group(['prefix' => 'despachos'], function()
		{
			Route::get('exportar/{despachos}', ['as' => 'ordenes.despachos.exportar', 'uses' => 'Production\DespachopController@exportar']);
			Route::get('pendientes', ['as' => 'ordenes.despachos.pendientes', 'uses' => 'Production\DespachopController@pendientes']);
		});
		Route::resource('despachos', 'Production\DespachopController', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('ordenes', 'Production\OrdenpController', ['except' => ['destroy']]);

	Route::resource('areasp', 'Production\AreaspController', ['except' => ['destroy']]);
	Route::resource('acabadosp', 'Production\AcabadospController', ['except' => ['destroy']]);
	Route::resource('maquinasp', 'Production\MaquinaspController', ['except' => ['destroy']]);
	Route::resource('materialesp', 'Production\MaterialespController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'productosp'], function()
	{
		Route::resource('tips', 'Production\Productop2Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('areas', 'Production\Productop3Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('maquinas', 'Production\Productop4Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('materiales', 'Production\Productop5Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('acabados', 'Production\Productop6Controller', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('productosp', 'Production\ProductopController', ['except' => ['destroy']]);

	/*
	|-------------------------
	| Inventory Routes
	|-------------------------
	*/
	Route::resource('grupos', 'Inventory\GrupoController', ['except' => ['destroy']]);
	Route::resource('subgrupos', 'Inventory\SubGrupoController', ['except' => ['destroy']]);
	Route::resource('unidades', 'Inventory\UnidadesMedidaController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'traslados'], function()
	{
		Route::resource('detalle', 'Inventory\DetalleTrasladoController', ['only' => ['index', 'store']]);
	});
   	Route::resource('traslados', 'Inventory\TrasladosController', ['only'=>['index', 'create', 'store', 'show']]);

	Route::group(['prefix' => 'productos'], function()
	{
		Route::get('search', ['as' => 'productos.search', 'uses' => 'Inventory\ProductoController@search']);
		Route::resource('rollos', 'Inventory\ProdbodeRolloController', ['only' => ['index']]);
	});
	Route::resource('productos', 'Inventory\ProductoController', ['except' => ['destroy']]);

   	/*
	|-------------------------
	| Reports Routes
	|-------------------------
	*/
   	Route::resource('rplancuentas', 'Report\PlanCuentasController', ['only' => ['index']]);
   	Route::resource('rmayorbalance', 'Report\MayorBalanceController', ['only' => ['index']]);
});
