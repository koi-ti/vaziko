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
Route::group(['prefix' => 'auth'], function () {
	Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
});
Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);

/*
|--------------------------------------------------------------------------
| Secure Routes Application
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

	/*
	|-------------------------
	| Special Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'search'], function () {
		Route::get('actividades', ['as' => 'search.actividades', 'uses' => 'Admin\BuscadorController@actividades']);
		Route::get('municipios', ['as' => 'search.municipios', 'uses' => 'Admin\BuscadorController@municipios']);
		Route::get('terceros', ['as' => 'search.terceros', 'uses' => 'Admin\BuscadorController@terceros']);
		Route::get('contactos', ['as' => 'search.contactos', 'uses' => 'Admin\BuscadorController@contactos']);
		Route::get('cuentas', ['as' => 'search.cuentas', 'uses' => 'Admin\BuscadorController@cuentas']);
		Route::get('cuentasnif', ['as' => 'search.cuentasnif', 'uses' => 'Admin\BuscadorController@cuentasnif']);
		Route::get('facturas', ['as' => 'search.facturas', 'uses' => 'Admin\BuscadorController@facturas']);
		Route::get('cotizaciones', ['as' => 'search.cotizaciones', 'uses' => 'Admin\BuscadorController@cotizaciones']);
		Route::get('ordenes', ['as' => 'search.ordenes', 'uses' => 'Admin\BuscadorController@ordenes']);
		Route::get('productos', ['as' => 'search.productos', 'uses' => 'Admin\BuscadorController@productos']);
		Route::get('productosp', ['as' => 'search.productosp', 'uses' => 'Admin\BuscadorController@productosp']);
		Route::get('productoscotizacion', ['as' => 'search.productoscotizacion', 'uses' => 'Admin\BuscadorController@productosCotizacion']);
		Route::get('productosorden', ['as' => 'search.productosorden', 'uses' => 'Admin\BuscadorController@productosOrden']);
		Route::get('subactividadesp', ['as' => 'search.subactividadesp', 'uses' => 'Admin\BuscadorController@subactividadesp']);
		Route::get('subtipoproductosp', ['as' => 'search.subtipoproductosp', 'uses' => 'Admin\BuscadorController@subtipoproductosp']);
		Route::get('documentos', ['as' => 'search.documentos', 'uses' => 'Admin\BuscadorController@documentos']);
		Route::get('facturasp', ['as' => 'search.facturasp', 'uses' => 'Admin\BuscadorController@facturasp']);
	});

	/*
	|-------------------------
	| Administracion
	|-------------------------
	*/
	Route::resource('empresa', 'Admin\EmpresaController', ['only' => ['index', 'update']]);
	Route::group(['prefix' => 'terceros'], function () {
		Route::get('dv', ['as' => 'terceros.dv', 'uses' => 'Admin\TerceroController@dv']);
		Route::get('rcree', ['as' => 'terceros.rcree', 'uses' => 'Admin\TerceroController@rcree']);
		Route::get('facturap', ['as' => 'terceros.facturap', 'uses' => 'Admin\TerceroController@facturap']);
		Route::post('setpassword', ['as' => 'terceros.setpassword', 'uses' => 'Admin\TerceroController@setpassword']);
		Route::group(['prefix' => 'contactos'], function () {
			Route::get('estado', ['as' => 'terceros.contactos.estado', 'uses' => 'Admin\ContactoController@estado']);
		});
		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index', 'store', 'update']]);
		Route::resource('roles', 'Admin\UsuarioRolController', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('imagenes', 'Admin\TerceroImagenController', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('terceros', 'Admin\TerceroController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'roles'], function () {
		Route::resource('permisos', 'Admin\PermisoRolController', ['only' => ['index', 'update', 'destroy']]);
	});
	Route::resource('roles', 'Admin\RolController', ['except' => ['destroy']]);
	Route::resource('actividades', 'Admin\ActividadController', ['except' => ['destroy']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index', 'show']]);
	Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('sucursales', 'Admin\SucursalController', ['except' => ['destroy']]);
	Route::resource('puntosventa', 'Admin\PuntoVentaController', ['except' => ['destroy']]);

	/*
	|-------------------
	| Cartera
	|-------------------
	*/
	Route::group(['prefix' => 'facturas'], function () {
		Route::get('impuestos', ['as' => 'facturas.impuestos', 'uses' => 'Receivable\Factura1Controller@impuestos']);
		Route::get('anular/{facturas}', ['as' => 'facturas.anular', 'uses' => 'Receivable\Factura1Controller@anular']);
		Route::get('exportar/{facturas}', ['as' => 'facturas.exportar', 'uses' => 'Receivable\Factura1Controller@exportar']);
		Route::resource('facturados', 'Receivable\Factura2Controller', ['only' => ['index', 'store']]);
		Route::resource('productos', 'Receivable\Factura4Controller', ['only' => ['index']]);
	});
	Route::resource('facturas', 'Receivable\Factura1Controller', ['only' => ['index', 'show', 'create', 'store']]);

	/*
	|-------------------------
	| Contabilidad
	|-------------------------
	*/
	Route::group(['prefix' => 'asientos'], function () {
		Route::get('reverse/{asientos}', ['as' => 'asientos.reverse', 'uses' => 'Accounting\AsientoController@reverse']);
		Route::get('exportar/{asientos}', ['as' => 'asientos.exportar', 'uses' => 'Accounting\AsientoController@exportar']);
		Route::post('import', ['as' => 'asientos.import', 'uses' => 'Accounting\AsientoController@import']);
		Route::group(['prefix' => 'detalle'], function () {
			Route::post('evaluate', ['as' => 'asientos.detalle.evaluate', 'uses' => 'Accounting\DetalleAsientoController@evaluate']);
			Route::post('validate', ['as' => 'asientos.detalle.validate', 'uses' => 'Accounting\DetalleAsientoController@validation']);
			Route::resource('movimientos', 'Accounting\AsientoMovimientoController', ['only' => ['index']]);
		});
		Route::resource('detalle', 'Accounting\DetalleAsientoController', ['only' => ['index', 'store', 'update', 'destroy']]);
	});
	Route::resource('asientos', 'Accounting\AsientoController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'asientosnif'], function () {
		Route::get('exportar/{asientosnif}', ['as' => 'asientosnif.exportar', 'uses' => 'Accounting\AsientoNifController@exportar']);
		Route::group(['prefix' => 'detalle'], function () {
			Route::post('evaluate', ['as' => 'asientosnif.detalle.evaluate', 'uses' => 'Accounting\AsientoNifDetalleController@evaluate']);
			Route::post('validate', ['as' => 'asientosnif.detalle.validate', 'uses' => 'Accounting\AsientoNifDetalleController@validation']);
			Route::get('movimientos', ['as' => 'asientosnif.detalle.movimientos', 'uses' => 'Accounting\AsientoNifDetalleController@movimientos']);
		});
		Route::resource('detalle', 'Accounting\AsientoNifDetalleController', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('asientosnif', 'Accounting\AsientoNifController', ['only' => ['index', 'edit', 'update', 'show']]);
	Route::resource('cierresmensuales', 'Accounting\CierreMensualController', ['except' => ['destroy']]);
	Route::resource('saldos', 'Accounting\SaldosController', ['only' => ['index']]);
	Route::resource('centroscosto', 'Accounting\CentroCostoController', ['except' => ['destroy']]);
	Route::resource('documentos', 'Accounting\DocumentoController', ['except' => ['destroy']]);
	Route::resource('folders', 'Accounting\FolderController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'plancuentas'], function () {
		Route::get('nivel', ['as' => 'plancuentas.nivel', 'uses' => 'Accounting\PlanCuentasController@nivel']);
	});
    Route::resource('plancuentas', 'Accounting\PlanCuentasController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'plancuentasnif'], function () {
		Route::get('nivel', ['as' => 'plancuentasnif.nivel', 'uses' => 'Accounting\PlanCuentasNifController@nivel']);
	});
    Route::resource('plancuentasnif', 'Accounting\PlanCuentasNifController', ['except' => ['destroy']]);

	/*
	|-------------------------
	| Inventario
	|-------------------------
	*/
	Route::group(['prefix' => 'productos'], function () {
		Route::post('evaluate', ['as' =>'productos.evaluate','uses'=>'Inventory\ProductoController@evaluate']);
		Route::resource('rollos', 'Inventory\ProdbodeRolloController', ['only' => ['index']]);
		Route::resource('prodbode', 'Inventory\ProdBodeController', ['only' => ['index']]);
		Route::resource('historial', 'Inventory\ProductoHistorialController', ['only' => ['index']]);
	});
	Route::resource('productos', 'Inventory\ProductoController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'traslados'], function () {
		Route::resource('detalle', 'Inventory\DetalleTrasladoController', ['only' => ['index', 'store']]);
	});
	Route::resource('traslados', 'Inventory\TrasladosController', ['only' => ['index', 'create', 'store', 'show']]);
	Route::resource('grupos', 'Inventory\GrupoController', ['except' => ['destroy']]);
	Route::resource('subgrupos', 'Inventory\SubGrupoController', ['except' => ['destroy']]);
	Route::resource('unidades', 'Inventory\UnidadesMedidaController', ['except' => ['destroy']]);

	/*
	|-------------------------
	| Production Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'agendaordenes'], function () {
		Route::get('exportar', ['as' => 'agendaordenes.exportar', 'uses' => 'Production\AgendaOrdenespController@exportar']);
	});
	Route::resource('agendaordenes', 'Production\AgendaOrdenespController', ['only' => ['index']]);
	Route::group(['prefix' => 'precotizaciones'], function () {
		Route::group(['prefix' => 'productos'], function () {
			Route::resource('maquinas', 'Production\PreCotizacion8Controller', ['only' => ['index']]);
			Route::resource('acabados', 'Production\PreCotizacion7Controller', ['only' => ['index']]);
			Route::resource('imagenes', 'Production\PreCotizacion4Controller', ['only' => ['index']]);
			Route::resource('materiales', 'Production\PreCotizacion3Controller', ['only' => ['index']]);
			Route::resource('empaques', 'Production\PreCotizacion9Controller', ['only' => ['index']]);
			Route::resource('areas', 'Production\PreCotizacion6Controller', ['only' => ['index']]);
			Route::resource('transportes', 'Production\PreCotizacion10Controller', ['only' => ['index']]);
		});
		Route::resource('productos', 'Production\PreCotizacion2Controller', ['only' => ['index', 'show']]);
	});
	Route::resource('precotizaciones', 'Production\PreCotizacion1Controller', ['only' => ['index', 'show']]);
	Route::group(['prefix' => 'cotizaciones'], function () {
		Route::get('exportar/{cotizaciones}', ['as' => 'cotizaciones.exportar', 'uses' => 'Production\Cotizacion1Controller@exportar']);
		Route::get('estados/{cotizaciones}', ['as' => 'cotizaciones.estados', 'uses' => 'Production\Cotizacion1Controller@estados']);
		Route::get('abrir/{cotizaciones}', ['as' => 'cotizaciones.abrir', 'uses' => 'Production\Cotizacion1Controller@abrir']);
		Route::get('clonar/{cotizaciones}', ['as' => 'cotizaciones.clonar', 'uses' => 'Production\Cotizacion1Controller@clonar']);
		Route::get('generar/{cotizaciones}', ['as' => 'cotizaciones.generar', 'uses' => 'Production\Cotizacion1Controller@generar']);
		Route::get('graficas/{cotizaciones}', ['as' => 'cotizaciones.graficas', 'uses' => 'Production\Cotizacion1Controller@graficas']);
		Route::resource('archivos', 'Production\CotizacionArchivosController', ['only' => ['index', 'store', 'destroy']]);
		Route::group(['prefix' => 'productos'], function () {
			Route::get('clonar/{productos}', ['as' => 'cotizaciones.productos.clonar', 'uses' => 'Production\Cotizacion2Controller@clonar']);
			Route::post('producto', ['as' => 'cotizaciones.productos.producto', 'uses' => 'Production\Cotizacion2Controller@producto']);
			Route::resource('maquinas', 'Production\Cotizacion3Controller', ['only' => ['index']]);
			Route::resource('acabados', 'Production\Cotizacion5Controller', ['only' => ['index']]);
			Route::resource('imagenes', 'Production\Cotizacion8Controller', ['only' => ['index', 'store', 'destroy']]);
			Route::resource('materiales', 'Production\Cotizacion4Controller', ['only' => ['index', 'store']]);
			Route::resource('empaques', 'Production\Cotizacion9Controller', ['only' => ['index', 'store']]);
			Route::resource('areas', 'Production\Cotizacion6Controller', ['only' => ['index', 'store']]);
			Route::resource('transportes', 'Production\Cotizacion10Controller', ['only' => ['index', 'store']]);
		});
		Route::resource('productos', 'Production\Cotizacion2Controller');
		Route::resource('bitacora', 'Admin\BitacoraController', ['only' => ['index']]);
	});
	Route::resource('cotizaciones', 'Production\Cotizacion1Controller', ['except' => ['destroy']]);
	Route::group(['prefix' => 'productosp'], function () {
		Route::get('clonar/{productosp}', ['as' => 'productosp.clonar', 'uses' => 'Production\ProductopController@clonar']);
		Route::resource('tips', 'Production\Productop2Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('areas', 'Production\Productop3Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('maquinas', 'Production\Productop4Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('materiales', 'Production\Productop5Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('acabados', 'Production\Productop6Controller', ['only' => ['index', 'store', 'destroy']]);
		Route::resource('imagenes', 'Production\ProductopImagenController', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('productosp', 'Production\ProductopController', ['except' => ['destroy']]);
	Route::group(['prefix' => 'ordenes'], function () {
		Route::get('cerrar/{ordenes}', ['as' => 'ordenes.cerrar', 'uses' => 'Production\OrdenpController@cerrar']);
		Route::get('abrir/{ordenes}', ['as' => 'ordenes.abrir', 'uses' => 'Production\OrdenpController@abrir']);
		Route::get('completar/{ordenes}', ['as' => 'ordenes.completar', 'uses' => 'Production\OrdenpController@completar']);
		Route::get('clonar/{ordenes}', ['as' => 'ordenes.clonar', 'uses' => 'Production\OrdenpController@clonar']);
		Route::get('exportar/{ordenes}', ['as' => 'ordenes.exportar', 'uses' => 'Production\OrdenpController@exportar']);
		Route::get('graficas/{ordenes}', ['as' => 'ordenes.graficas', 'uses' => 'Production\OrdenpController@graficas']);
		Route::resource('archivos', 'Production\OrdenpArchivosController', ['only' => ['index', 'store', 'destroy']]);
		Route::group(['prefix' => 'productos'], function () {
			Route::get('clonar/{productos}', ['as' => 'ordenes.productos.clonar', 'uses' => 'Production\DetalleOrdenpController@clonar']);
			Route::post('producto', ['as' => 'ordenes.productos.producto', 'uses' => 'Production\DetalleOrdenpController@producto']);
			Route::resource('maquinas', 'Production\DetalleMaquinaController', ['only' => ['index']]);
			Route::resource('acabados', 'Production\DetalleAcabadoController', ['only' => ['index']]);
			Route::resource('imagenes', 'Production\DetalleImagenespController', ['only' => ['index', 'store', 'destroy']]);
			Route::resource('materiales', 'Production\DetalleMaterialesController', ['only' => ['index', 'store']]);
			Route::resource('empaques', 'Production\DetalleEmpaquesController', ['only' => ['index', 'store']]);
			Route::resource('areas', 'Production\DetalleAreasController', ['only' => ['index', 'store']]);
			Route::resource('transportes', 'Production\DetalleTransportesController', ['only' => ['index', 'store']]);
		});
		Route::resource('productos', 'Production\DetalleOrdenpController');
		Route::resource('bitacora', 'Admin\BitacoraController', ['only' => ['index']]);
		Route::group(['prefix' => 'despachos'], function () {
			Route::get('exportar/{despachos}', ['as' => 'ordenes.despachos.exportar', 'uses' => 'Production\DespachopController@exportar']);
			Route::get('pendientes', ['as' => 'ordenes.despachos.pendientes', 'uses' => 'Production\DespachopController@pendientes']);
		});
		Route::resource('despachos', 'Production\DespachopController', ['only' => ['index', 'store', 'destroy']]);
	});
	Route::resource('ordenes', 'Production\OrdenpController', ['except' => ['destroy']]);
	Route::resource('tiemposp', 'Production\TiempopController', ['except' => ['destroy']]);
	Route::resource('acabadosp', 'Production\AcabadospController', ['except' => ['destroy']]);
	Route::resource('actividadesp', 'Production\ActividadpController', ['except' => ['destroy']]);
	Route::resource('areasp', 'Production\AreaspController', ['except' => ['destroy']]);
	Route::resource('maquinasp', 'Production\MaquinaspController', ['except' => ['destroy']]);
	Route::resource('materialesp', 'Production\MaterialespController', ['except' => ['destroy']]);
	Route::resource('tipomaterialesp', 'Production\TipoMaterialespController', ['except' => ['destroy']]);
	Route::resource('tipoproductosp', 'Production\TipoProductopController', ['except' => ['destroy']]);
	Route::resource('subactividadesp', 'Production\SubActividadpController', ['except' => ['destroy']]);
	Route::resource('subtipoproductosp', 'Production\SubtipoProductopController', ['except' => ['destroy']]);

	/*
	|-------------------------
	| Tesoreria
	|-------------------------
	*/
	Route::group(['prefix' => 'facturasp'], function () {
		Route::resource('cuotas', 'Treasury\FacturapCuotasController', ['only' => ['index']]);
	});
	Route::resource('facturasp', 'Treasury\FacturapController', ['only' => ['index', 'show']]);

   	/*
	|-------------------------
	| Reports Routes
	|-------------------------
	*/
	// Cartera
	Route::resource('restadocartera', 'Report\EstadoCarteraController', ['only' => ['index']]);
	Route::resource('rcarteraedades', 'Report\CarteraEdadesController', ['only' => ['index']]);

	// Contabilidad
	Route::resource('rauxbeneficiariocuenta', 'Report\AuxiliarBeneficiarioCuentaController', ['only' => ['index']]);
	Route::resource('rauxcontable', 'Report\AuxiliarContableController', ['only' => ['index']]);
	Route::resource('rauxcuenta', 'Report\AuxiliarCuentaController', ['only' => ['index']]);
	Route::resource('rbalancegeneral', 'Report\BalanceGeneralController', ['only' => ['index']]);
	Route::resource('rlibrodiario', 'Report\LibroDiarioController', ['only' => ['index']]);
	Route::resource('rlibromayor', 'Report\LibroMayorController', ['only' => ['index']]);

	// Produccion
	Route::group(['prefix' => 'rtiemposp'], function () {
		Route::get('graficas', ['as' => 'rtiemposp.graficas', 'uses' => 'Report\TiempopController@graficas']);
		Route::get('exportar', ['as' => 'rtiemposp.exportar', 'uses' => 'Report\TiempopController@exportar']);
	});
	Route::resource('rtiemposp', 'Report\TiempopController', ['only' => ['index']]);
	Route::resource('rresumentiemposp', 'Report\ResumenTiempopController', ['only' => ['index']]);

	// Tesoreria
	Route::resource('rhistorialproveedores', 'Report\HistorialProveedorController', ['only' => ['index']]);
});
