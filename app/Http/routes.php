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
		Route::post('setpassword', ['as' => 'terceros.setpassword', 'uses' => 'Admin\TerceroController@setpassword']);
		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index', 'store', 'update']]);
		Route::resource('roles', 'Admin\UsuarioRolController', ['only' => ['index', 'store', 'destroy']]);
	});

	Route::resource('terceros', 'Admin\TerceroController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('empresa', 'Admin\EmpresaController', ['only' => ['index', 'update']]);
    Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('actividades', 'Admin\ActividadController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index', 'show']]);
	Route::resource('sucursales', 'Admin\SucursalController', ['except' => ['destroy']]);
	Route::resource('puntosventa', 'Admin\PuntoVentaController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'roles'], function()
	{
		Route::resource('permisos', 'Admin\PermisoRolController', ['only' => ['index', 'update', 'destroy']]);
	});

	Route::resource('roles', 'Admin\RolController', ['except' => ['destroy']]);
    Route::resource('permisos', 'Admin\PermisoController', ['only' => ['index']]);
    Route::resource('modulos', 'Admin\ModuloController', ['only' => ['index']]);

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

	Route::group(['prefix' => 'plancuentasnif'], function()
	{
		Route::get('nivel', ['as' => 'plancuentasnif.nivel', 'uses' => 'Accounting\PlanCuentasNifController@nivel']);
		Route::get('search', ['as' => 'plancuentasnif.search', 'uses' => 'Accounting\PlanCuentasNifController@search']);
	});
    Route::resource('plancuentasnif', 'Accounting\PlanCuentasNifController', ['except' => ['destroy']]);

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

	Route::group(['prefix' => 'asientosnif'], function()
	{
		Route::resource('detalle', 'Accounting\AsientoNifDetalleController', ['only' => ['index', 'store', 'destroy']]);
		Route::get('exportar/{asientosnif}', ['as' => 'asientosnif.exportar', 'uses' => 'Accounting\AsientoNifController@exportar']);

		Route::group(['prefix' => 'detalle'], function()
		{
			Route::post('evaluate', ['as' => 'asientosnif.detalle.evaluate', 'uses' => 'Accounting\AsientoNifDetalleController@evaluate']);
			Route::post('validate', ['as' => 'asientosnif.detalle.validate', 'uses' => 'Accounting\AsientoNifDetalleController@validation']);
			Route::get('movimientos', ['as' => 'asientosnif.detalle.movimientos', 'uses' => 'Accounting\AsientoNifDetalleController@movimientos']);
		});
	});
	Route::resource('asientosnif', 'Accounting\AsientoNifController', ['only' => ['index', 'edit', 'update', 'show']]);
	Route::resource('reglasasientos', 'Accounting\ReglaAsientoController', ['only' => ['index', 'store']]);
	Route::resource('cierresmensuales', 'Accounting\CierreMensualController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);

	Route::resource('centroscosto', 'Accounting\CentroCostoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
   	Route::resource('folders', 'Accounting\FolderController', ['only'=>['index', 'create', 'store', 'edit', 'update', 'show']]);


   	/*
   	|-------------------
   	| Receivable
   	|-------------------
   	*/
	Route::group(['prefix' => 'facturas'], function()
	{
		Route::get('search', ['as' => 'facturas.search', 'uses' => 'Receivable\Factura1Controller@search']);
		Route::get('exportar/{facturas}', ['as' => 'facturas.exportar', 'uses' => 'Receivable\Factura1Controller@exportar']);
		Route::resource('comentario', 'Receivable\Factura3Controller', ['only' => ['index', 'store']]);
		Route::resource('facturado', 'Receivable\Factura2Controller', ['only' => ['index', 'store']]);
		Route::resource('detalle', 'Receivable\Factura4Controller', ['only' => ['index']]);
	});
	Route::resource('facturas', 'Receivable\Factura1Controller', ['only' => ['index', 'show','create','store']]);
   	/*
	|-------------------------
	| Supplier invoice Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'facturap'], function()
	{
		Route::get('search', ['as' => 'facturap.search', 'uses' => 'Treasury\FacturapController@search']);
		Route::resource('cuotas', 'Treasury\FacturapCuotasController', ['only' => ['index']]);
	});
	Route::resource('facturap', 'Treasury\FacturapController', ['only' => ['index','show']]);

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
		Route::get('charts/{ordenes}', ['as' => 'ordenes.charts', 'uses' => 'Production\OrdenpController@charts']);

		Route::group(['prefix' => 'productos'], function()
		{
			Route::get('clonar/{productos}', ['as' => 'ordenes.productos.clonar', 'uses' => 'Production\DetalleOrdenpController@clonar']);
			Route::get('search', ['as' => 'ordenes.productos.search', 'uses' => 'Production\DetalleOrdenpController@search']);
			Route::resource('maquinas', 'Production\DetalleMaquinasController', ['only' => ['index']]);
			Route::resource('materiales', 'Production\DetalleMaterialesController', ['only' => ['index']]);
			Route::resource('acabados', 'Production\DetalleAcabadosController', ['only' => ['index']]);
			Route::resource('areas', 'Production\DetalleAreasController', ['only' => ['index', 'store', 'destroy']]);
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

	Route::resource('actividadesp', 'Production\ActividadpController', ['except' => ['destroy']]);
	Route::resource('subactividadesp', 'Production\SubActividadpController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'tiemposp'], function() {
		Route::resource('detalle', 'Production\DetalleTiempospController', ['only' => ['index', 'update']]);
	});

	Route::resource('tiemposp', 'Production\TiempopController', ['except' => ['destroy']]);

	Route::resource('areasp', 'Production\AreaspController', ['except' => ['destroy']]);
	Route::resource('acabadosp', 'Production\AcabadospController', ['except' => ['destroy']]);
	Route::resource('maquinasp', 'Production\MaquinaspController', ['except' => ['destroy']]);
	Route::resource('materialesp', 'Production\MaterialespController', ['except' => ['destroy']]);
	Route::resource('tipomaterialesp', 'Production\TipoMaterialespController', ['except' => ['destroy']]);
	Route::resource('tipoproductosp', 'Production\TipoProductopController', ['except' => ['destroy']]);
	Route::resource('subtipoproductosp', 'Production\SubtipoProductopController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'precotizaciones'], function(){
		Route::get('cerrar/{precotizaciones}', ['as' => 'precotizaciones.cerrar', 'uses' => 'Production\PreCotizacion1Controller@cerrar']);
		Route::get('abrir/{precotizaciones}', ['as' => 'precotizaciones.abrir', 'uses' => 'Production\PreCotizacion1Controller@abrir']);
		
		Route::group(['prefix' => 'productos'], function(){
			Route::resource('materiales', 'Production\PreCotizacion3Controller', ['only' => ['index', 'store', 'destroy']]);
			Route::resource('imagenes', 'Production\PreCotizacion4Controller');
		});
		Route::resource('productos', 'Production\PreCotizacion2Controller');
	});
	Route::resource('precotizaciones', 'Production\PreCotizacion1Controller', ['except' => ['destroy']]);

	Route::group(['prefix' => 'cotizaciones'], function(){
		Route::get('search', ['as' => 'cotizaciones.search', 'uses' => 'Production\Cotizacion1Controller@search']);
		Route::get('exportar/{cotizaciones}', ['as' => 'cotizaciones.exportar', 'uses' => 'Production\Cotizacion1Controller@exportar']);
		Route::get('cerrar/{cotizaciones}', ['as' => 'cotizaciones.cerrar', 'uses' => 'Production\Cotizacion1Controller@cerrar']);
		Route::get('abrir/{cotizaciones}', ['as' => 'cotizaciones.abrir', 'uses' => 'Production\Cotizacion1Controller@abrir']);
		Route::get('clonar/{cotizaciones}', ['as' => 'cotizaciones.clonar', 'uses' => 'Production\Cotizacion1Controller@clonar']);
		Route::get('generar/{cotizaciones}', ['as' => 'cotizaciones.generar', 'uses' => 'Production\Cotizacion1Controller@generar']);

		Route::get('productos/formula', ['as' => 'cotizaciones.productos.formula', 'uses' => 'Production\Cotizacion2Controller@formula']);

		Route::group(['prefix' => 'productos'], function(){
			Route::get('clonar/{productos}', ['as' => 'cotizaciones.productos.clonar', 'uses' => 'Production\Cotizacion2Controller@clonar']);
			Route::resource('maquinas', 'Production\Cotizacion3Controller', ['only' => ['index']]);
			Route::resource('materiales', 'Production\Cotizacion4Controller', ['only' => ['index']]);
			Route::resource('acabados', 'Production\Cotizacion5Controller', ['only' => ['index']]);
			Route::resource('areas', 'Production\Cotizacion6Controller', ['only' => ['index', 'store', 'destroy']]);
		});
		Route::resource('productos', 'Production\Cotizacion2Controller');
	});
	Route::resource('cotizaciones', 'Production\Cotizacion1Controller', ['except' => ['destroy']]);


	Route::group(['prefix' => 'productosp'], function(){
		Route::get('search', ['as' => 'productosp.search', 'uses' => 'Production\ProductopController@search']);
		Route::get('clonar/{productosp}', ['as' => 'productosp.clonar', 'uses' => 'Production\ProductopController@clonar']);
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
		Route::post('evaluate',['as' =>'productos.evaluate','uses'=>'Inventory\ProductoController@evaluate'] );
		Route::resource('rollos', 'Inventory\ProdbodeRolloController', ['only' => ['index']]);
		Route::resource('prodbode', 'Inventory\ProdBodeController', ['only' => ['index']]);
	});
	Route::resource('productos', 'Inventory\ProductoController', ['except' => ['destroy']]);

   	/*
	|-------------------------
	| Reports Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'rtiemposp'], function(){
		Route::get('charts', ['as' => 'rtiemposp.charts', 'uses' => 'Report\TiempopController@charts']);
		Route::get('exportar', ['as' => 'rtiemposp.exportar', 'uses' => 'Report\TiempopController@exportar']);
	});
	Route::resource('rtiemposp', 'Report\TiempopController', ['only' => ['index']]);

   	Route::resource('rplancuentas', 'Report\PlanCuentasController', ['only' => ['index']]);
   	Route::resource('rmayorbalance', 'Report\MayorBalanceController', ['only' => ['index']]);
	Route::resource('rhistorialproveedores', 'Report\HistorialProveedorController', ['only' => ['index']]);
	Route::resource('rlibrodiario', 'Report\LibroDiarioController', ['only' => ['index']]);
	Route::resource('rlibromayor', 'Report\LibroMayorController', ['only' => ['index']]);
	Route::resource('rauxcontable', 'Report\AuxiliarContableController', ['only' => ['index']]);
	Route::resource('rimpuestos', 'Report\RelacionImpuestosController', ['only' => ['index']]);
});
