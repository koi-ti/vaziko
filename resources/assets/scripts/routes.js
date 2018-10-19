/**
* Class AppRouter  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AppRouter = new( Backbone.Router.extend({
        routes : {
            'login(/)': 'getLogin',
            'terceros(/)': 'getTercerosMain',
            'terceros/create(/)': 'getTercerosCreate',
            'terceros/:tercero(/)': 'getTercerosShow',
            'terceros/:tercero/edit(/)': 'getTercerosEdit',

            'empresa(/)': 'getEmpresaEdit',
            'municipios(/)': 'getMunicipiosMain',
            'departamentos(/)': 'getDepartamentosMain',

            'actividades(/)': 'getActividadesMain',
            'actividades/create(/)': 'getActividadesCreate',
            'actividades/:actividad/edit(/)': 'getActividadesEdit',

            'sucursales(/)': 'getSucursalesMain',
            'sucursales/create(/)': 'getSucursalesCreate',
            'sucursales/:sucursal/edit(/)': 'getSucursalesEdit',

            'roles(/)': 'getRolesMain',
            'roles/create(/)': 'getRolesCreate',
            'roles/:rol/edit(/)': 'getRolesEdit',

            'permisos(/)': 'getPermisosMain',
            'modulos(/)': 'getModulosMain',

            'puntosventa(/)': 'getPuntosVentaMain',
            'puntosventa/create(/)': 'getPuntosVentaCreate',
            'puntosventa/:puntoventa/edit(/)': 'getPuntosVentaEdit',

            // Cartera
            'facturas(/)': 'getFacturasMain',
            'facturas/create(/)': 'getFacturaCreate',
            'facturas/:facturas(/)': 'getFacturaShow',

            // Contabilidad
            'plancuentas(/)': 'getPlanCuentasMain',
            'plancuentas/create(/)': 'getPlanCuentasCreate',
            'plancuentas/:plancuenta/edit(/)': 'getPlanCuentasEdit',

            'plancuentasnif(/)': 'getPlanCuentasNifMain',
            'plancuentasnif/create(/)': 'getPlanCuentasNifCreate',
            'plancuentasnif/:plancuentanif/edit(/)': 'getPlanCuentasNifEdit',

            'centroscosto(/)': 'getCentrosCostoMain',
            'centroscosto/create(/)': 'getCentrosCostoCreate',
            'centroscosto/:centrocosto/edit(/)': 'getCentrosCostoEdit',

            'asientos(/)': 'getAsientosMain',
            'asientos/create(/)': 'getAsientosCreate',
            'asientos/:asientos(/)': 'getAsientosShow',
            'asientos/:asiento/edit(/)': 'getAsientosEdit',

            'asientosnif(/)': 'getAsientosNifMain',
            'asientosnif/:asientonif(/)': 'getAsientosNifShow',
            'asientosnif/:asientonif/edit(/)': 'getAsientosNifEdit',

            'cierresmensuales(/)': 'getCierreMensualCreate',

            'documentos(/)': 'getDocumentosMain',
            'documentos/create(/)': 'getDocumentosCreate',
            'documentos/:documento/edit(/)':'getDocumentosEdit',

            'folders(/)': 'getFoldersMain',
            'folders/create(/)': 'getFoldersCreate',
            'folders/:folder/edit(/)':'getFoldersEdit',

            // Inventario
            'subgrupos(/)': 'getSubGruposMain',
            'subgrupos/create(/)': 'getSubGruposCreate',
            'subgrupos/:subgrupo/edit(/)': 'getSubGruposEdit',

            'grupos(/)': 'getGruposMain',
            'grupos/create(/)': 'getGruposCreate',
            'grupos/:grupo/edit(/)': 'getGruposEdit',

            'unidades(/)': 'getUnidadesMain',
            'unidades/create(/)': 'getUnidadesCreate',
            'unidades/:unidad/edit(/)': 'getUnidadesEdit',

            'productos(/)': 'getProductosMain',
            'productos/create(/)': 'getProductosCreate',
            'productos/:producto(/)': 'getProductoShow',
            'productos/:producto/edit(/)': 'getProductosEdit',

            'traslados(/)': 'getTrasladosMain',
            'traslados/create(/)': 'getTrasladosCreate',
            'traslados/:traslado(/)': 'getTrasladosShow',

            // Produccion
            'tiemposp(/)': 'getTiempopMain',

            // Reporte tiemposp
            'rtiemposp(/)': 'getReporteTiempospMain',

            'areasp(/)': 'getAreaspMain',
            'areasp/create(/)': 'getAreaspCreate',
            'areasp/:areap/edit(/)': 'getAreaspEdit',

            'actividadesp(/)': 'getActividadespMain',
            'actividadesp/create(/)': 'getActividadespCreate',
            'actividadesp/:actividadp/edit(/)': 'getActividadespEdit',

            'subactividadesp(/)': 'getSubActividadespMain',
            'subactividadesp/create(/)': 'getSubActividadespCreate',
            'subactividadesp/:subactividadp/edit(/)': 'getSubActividadespEdit',

            'acabadosp(/)': 'getAcabadospMain',
            'acabadosp/create(es/)':'getAcabadospCreate',
            'acabadosp/:acabadop/edit(/)': 'getAcabadospEdit',

            'maquinasp(/)': 'getMaquinaspMain',
            'maquinasp/create(/)': 'getMaquinaspCreate',
            'maquinasp/:maquinap/edit(/)': 'getMaquinaspEdit',

            'materialesp(/)': 'getMaterialespMain',
            'materialesp/create(/)': 'getMaterialespCreate',
            'materialesp/:materialp/edit(/)': 'getMaterialespEdit',

            'tipomaterialesp(/)': 'getTipoMaterialespMain',
            'tipomaterialesp/create(/)': 'getTipoMaterialpCreate',
            'tipomaterialesp/:tipomaterialesp/edit(/)': 'getTipoMaterialpEdit',

            'tipoproductosp(/)': 'getTipoProductopMain',
            'tipoproductosp/create(/)': 'getTipoProductopCreate',
            'tipoproductosp/:tipoproductosp/edit(/)': 'getTipoProductopEdit',

            'subtipoproductosp(/)': 'getSubtipoProductopMain',
            'subtipoproductosp/create(/)': 'getSubtipoProductopCreate',
            'subtipoproductosp/:subtipoproductosp/edit(/)': 'getSubtipoProductopEdit',

            'ordenes(/)': 'getOrdenesMain',
            'ordenes/create(/)': 'getOrdenesCreate',
            'ordenes/:orden(/)': 'getOrdenesShow',
            'ordenes/:orden/edit(/)': 'getOrdenesEdit',
            'ordenes/productos/create(/)(?*queryString)': 'getOrdenesProductoCreate',
            'ordenes/productos/:producto/edit(/)': 'getOrdenesProductoEdit',
            'ordenes/productos/:producto(/)': 'getOrdenesProductoShow',

            'productosp(/)': 'getProductospMain',
            'productosp/create(/)': 'getProductospCreate',
            'productosp/:producto(/)': 'getProductospShow',
            'productosp/:producto/edit(/)': 'getProductospEdit',

            'precotizaciones(/)': 'getPreCotizacionesMain',
            'precotizaciones/create(/)': 'getPreCotizacionesCreate',
            'precotizaciones/:precotizaciones(/)': 'getPreCotizacionesShow',
            'precotizaciones/:precotizaciones/edit(/)': 'getPreCotizacionesEdit',
            'precotizaciones/productos/create(/)(?*queryString)': 'getPreCotizacionesProductoCreate',
            'precotizaciones/productos/:producto(/)': 'getPreCotizacionesProductoShow',
            'precotizaciones/productos/:producto/edit(/)': 'getPreCotizacionesProductoEdit',

            'cotizaciones(/)': 'getCotizacionesMain',
            'cotizaciones/create(/)': 'getCotizacionesCreate',
            'cotizaciones/:cotizaciones(/)': 'getCotizacionesShow',
            'cotizaciones/:cotizaciones/edit(/)': 'getCotizacionesEdit',
            'cotizaciones/productos/create(/)(?*queryString)': 'getCotizacionesProductoCreate',
            'cotizaciones/productos/:producto(/)': 'getCotizacionesProductoShow',
            'cotizaciones/productos/:producto/edit(/)': 'getCotizacionesProductoEdit',

            // Treasury
            'facturap(/)': 'getFacturaspMain',
            'facturap(/):facturap(/)': 'getFacturaspShow',
        },

        /**
        * Parse queryString to object
        */
        parseQueryString : function(queryString) {
            var params = {};
            if(queryString) {
                _.each(
                    _.map(decodeURI(queryString).split(/&/g),function(el,i){
                        var aux = el.split('='), o = {};
                        if(aux.length >= 1){
                            var val = undefined;
                            if(aux.length == 2)
                                val = aux[1];
                            o[aux[0]] = val;
                        }
                        return o;
                    }),
                    function(o){
                        _.extend(params,o);
                    }
                );
            }
            return params;
        },

        /**
        * Constructor Method
        */
        initialize : function ( opts ){
            // Initialize resources
            this.componentGlobalView = new app.ComponentGlobalView();
            this.componentAddressView = new app.ComponentAddressView();
            this.componentCreateResourceView = new app.ComponentCreateResourceView();
            this.componentSearchTerceroView = new app.ComponentSearchTerceroView();
            this.componentSearchCuentaView = new app.ComponentSearchCuentaView();
            this.componentDocumentView = new app.ComponentDocumentView();
            this.componentReportView = new app.ComponentReportView();
            this.componentTerceroView = new app.ComponentTerceroView();
            this.componentSearchFacturaView = new app.ComponentSearchFacturaView();
            this.componentSearchOrdenPView = new app.ComponentSearchOrdenPView();
            this.componentSearchOrdenP2View = new app.ComponentSearchOrdenP2View();
            this.componentSearchProductoView = new app.ComponentSearchProductoView();
            this.componentSearchProductopView = new app.ComponentSearchProductopView();
            this.componentSearchContactoView = new app.ComponentSearchContactoView();
            this.componentSearchCotizacionView = new app.ComponentSearchCotizacionView();
            this.componentConsecutiveView = new app.ComponentConsecutiveView();
      	},

        /**
        * Start Backbone history
        */
        start: function () {
            var config = { pushState: true };

            if( document.domain.search(/(104.236.57.82|localhost)/gi) != '-1' ) {
                config.root = '/vaziko/public/';
            }

            Backbone.history.start( config );
        },

        /**
        * show view in Calendar Event
        * @param String show
        */
        getLogin: function () {

            if ( this.loginView instanceof Backbone.View ){
                this.loginView.stopListening();
                this.loginView.undelegateEvents();
            }

            this.loginView = new app.UserLoginView( );
        },

        /**
        * show view main terceros
        */
        getTercerosMain: function () {

            if ( this.mainTerceroView instanceof Backbone.View ){
                this.mainTerceroView.stopListening();
                this.mainTerceroView.undelegateEvents();
            }

            this.mainTerceroView = new app.MainTerceroView( );
        },

        /**
        * show view create terceros
        */
        getTercerosCreate: function () {
            this.terceroModel = new app.TerceroModel();

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            this.createTerceroView = new app.CreateTerceroView({ model: this.terceroModel });
            this.createTerceroView.render();
        },

        /**
        * show view show tercero
        */
        getTercerosShow: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.showTerceroView instanceof Backbone.View ){
                this.showTerceroView.stopListening();
                this.showTerceroView.undelegateEvents();
            }

            this.showTerceroView = new app.ShowTerceroView({ model: this.terceroModel });
        },

        /**
        * show view edit terceros
        */
        getTercerosEdit: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            if ( this.editTerceroView instanceof Backbone.View ){
                this.editTerceroView.stopListening();
                this.editTerceroView.undelegateEvents();
            }

            this.editTerceroView = new app.EditTerceroView({ model: this.terceroModel });
            this.terceroModel.fetch();
        },

        /**
        * show view edit empresa
        */
        getEmpresaEdit: function () {
            this.empresaModel = new app.EmpresaModel();

            if ( this.createEmpresaView instanceof Backbone.View ){
                this.createEmpresaView.stopListening();
                this.createEmpresaView.undelegateEvents();
            }

            this.createEmpresaView = new app.CreateEmpresaView({ model: this.empresaModel });
            this.empresaModel.fetch();
        },

        /**
        * show view main municipios
        */
        getMunicipiosMain: function () {

            if ( this.mainMunicipioView instanceof Backbone.View ){
                this.mainMunicipioView.stopListening();
                this.mainMunicipioView.undelegateEvents();
            }

            this.mainMunicipioView = new app.MainMunicipioView( );
        },

        /**
        * show view main departamentos
        */
        getDepartamentosMain: function () {

            if ( this.mainDepartamentoView instanceof Backbone.View ){
                this.mainDepartamentoView.stopListening();
                this.mainDepartamentoView.undelegateEvents();
            }

            this.mainDepartamentoView = new app.MainDepartamentoView( );
        },

        /**
        * show view main actividades
        */
        getActividadesMain: function () {

            if ( this.mainActividadView instanceof Backbone.View ){
                this.mainActividadView.stopListening();
                this.mainActividadView.undelegateEvents();
            }

            this.mainActividadView = new app.MainActividadView( );
        },

        /**
        * show view create actividades
        */
        getActividadesCreate: function () {
            this.actividadModel = new app.ActividadModel();

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.createActividadView.render();
        },

        /**
        * show view edit actividades
        */
        getActividadesEdit: function (actividad) {
            this.actividadModel = new app.ActividadModel();
            this.actividadModel.set({'id': actividad}, {silent: true});

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.actividadModel.fetch();
        },

        /**
        * show view main sucursales
        */
        getSucursalesMain: function () {

            if ( this.mainSucursalesView instanceof Backbone.View ){
                this.mainSucursalesView.stopListening();
                this.mainSucursalesView.undelegateEvents();
            }

            this.mainSucursalesView = new app.MainSucursalesView( );
        },

        /**
        * show view create sucursales
        */
        getSucursalesCreate: function () {
            this.sucursalModel = new app.SucursalModel();

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.createSucursalView.render();
        },

        /**
        * show view edit sucursales
        */
        getSucursalesEdit: function (sucursal) {
            this.sucursalModel = new app.SucursalModel();
            this.sucursalModel.set({'id': sucursal}, {silent: true});

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.sucursalModel.fetch();
        },

        /**
        * show view main roles
        */
        getRolesMain: function () {

            if ( this.mainRolesView instanceof Backbone.View ){
                this.mainRolesView.stopListening();
                this.mainRolesView.undelegateEvents();
            }

            this.mainRolesView = new app.MainRolesView( );
        },

        /**
        * show view create roles
        */
        getRolesCreate: function () {
            this.rolModel = new app.RolModel();

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.createRolView = new app.CreateRolView({ model: this.rolModel });
            this.createRolView.render();
        },

        /**
        * show view edit roles
        */
        getRolesEdit: function (rol) {
            this.rolModel = new app.RolModel();
            this.rolModel.set({'id': rol}, {silent: true});

            if ( this.editRolView instanceof Backbone.View ){
                this.editRolView.stopListening();
                this.editRolView.undelegateEvents();
            }

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.editRolView = new app.EditRolView({ model: this.rolModel });
            this.rolModel.fetch();
        },

        /**
        * show main view permisos
        */
        getPermisosMain: function () {

            if ( this.mainPermisoView instanceof Backbone.View ){
                this.mainPermisoView.stopListening();
                this.mainPermisoView.undelegateEvents();
            }

            this.mainPermisoView = new app.MainPermisoView( );
        },

        /**
        * show main view modulos
        */
        getModulosMain: function () {

            if ( this.mainModuloView instanceof Backbone.View ){
                this.mainModuloView.stopListening();
                this.mainModuloView.undelegateEvents();
            }

            this.mainModuloView = new app.MainModuloView( );
        },

        /**
        * show view main puntos de venta
        */
        getPuntosVentaMain: function () {

            if ( this.mainPuntoventaView instanceof Backbone.View ){
                this.mainPuntoventaView.stopListening();
                this.mainPuntoventaView.undelegateEvents();
            }

            this.mainPuntoventaView = new app.MainPuntoventaView( );
        },

        /**
        * show view create puntos de venta
        */
        getPuntosVentaCreate: function () {
            this.puntoVentaModel = new app.PuntoVentaModel();

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.createPuntoventaView.render();
        },

        /**
        * show view edit puntos de venta
        */
        getPuntosVentaEdit: function (puntoventa) {
            this.puntoVentaModel = new app.PuntoVentaModel();
            this.puntoVentaModel.set({'id': puntoventa}, {silent: true});

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.puntoVentaModel.fetch();
        },

        /**
        * show view main plan de cuentas
        */
        getPlanCuentasMain: function () {

            if ( this.mainPlanCuentasView instanceof Backbone.View ){
                this.mainPlanCuentasView.stopListening();
                this.mainPlanCuentasView.undelegateEvents();
            }

            this.mainPlanCuentasView = new app.MainPlanCuentasView( );
        },

        /**
        * show view create cuenta contable
        */
        getPlanCuentasCreate: function () {
            this.planCuentaModel = new app.PlanCuentaModel();

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.createPlanCuentaView.render();
        },

        /**
        * show view edit cuenta contable
        */
        getPlanCuentasEdit: function (plancuenta) {
            this.planCuentaModel = new app.PlanCuentaModel();
            this.planCuentaModel.set({'id': plancuenta}, {silent: true});

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.planCuentaModel.fetch();
        },

        /**
        * show view main cuenta NIF contable
        */
        getPlanCuentasNifMain: function () {

            if ( this.mainPlanCuentasNifView instanceof Backbone.View ){
                this.mainPlanCuentasNifView.stopListening();
                this.mainPlanCuentasNifView.undelegateEvents();
            }

            this.mainPlanCuentasNifView = new app.MainPlanCuentasNifView( );
        },
        /**
        * show view create cuenta NIF contable
        */
        getPlanCuentasNifCreate: function () {
            this.planCuentaNifModel = new app.PlanCuentaNifModel();

            if ( this.createPlanCuentaNifView instanceof Backbone.View ){
                this.createPlanCuentaNifView.stopListening();
                this.createPlanCuentaNifView.undelegateEvents();
            }

            this.createPlanCuentaNifView = new app.CreatePlanCuentaNifView({ model: this.planCuentaNifModel });
            this.createPlanCuentaNifView.render();
        },
        /**
        * show view edit cuenta NIF contable
        */
        getPlanCuentasNifEdit: function (plancuentanif) {
            this.planCuentaNifModel = new app.PlanCuentaNifModel();
            this.planCuentaNifModel.set({'id': plancuentanif}, {silent: true});

            if ( this.createPlanCuentaNifView instanceof Backbone.View ){
                this.createPlanCuentaNifView.stopListening();
                this.createPlanCuentaNifView.undelegateEvents();
            }

            this.createPlanCuentaNifView = new app.CreatePlanCuentaNifView({ model: this.planCuentaNifModel });
            this.planCuentaNifModel.fetch();
        },
        /**
        * show view main centros de costo
        */
        getCentrosCostoMain: function () {

            if ( this.mainCentrosCostoView instanceof Backbone.View ){
                this.mainCentrosCostoView.stopListening();
                this.mainCentrosCostoView.undelegateEvents();
            }

            this.mainCentrosCostoView = new app.MainCentrosCostoView( );
        },

        /**
        * show view create centro de costo
        */
        getCentrosCostoCreate: function () {
            this.centroCostoModel = new app.CentroCostoModel();

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.createCentroCostoView.render();
        },

        /**
        * show view edit centro de costo
        */
        getCentrosCostoEdit: function (centrocosto) {
            this.centroCostoModel = new app.CentroCostoModel();
            this.centroCostoModel.set({'id': centrocosto}, {silent: true});

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.centroCostoModel.fetch();
        },

        /**
        * show view main asientos contables
        */
        getAsientosMain: function () {

            if ( this.mainAsientosView instanceof Backbone.View ){
                this.mainAsientosView.stopListening();
                this.mainAsientosView.undelegateEvents();
            }

            this.mainAsientosView = new app.MainAsientosView( );
        },

        /**
        * show view create asiento contable
        */
        getAsientosCreate: function () {
            this.asientoModel = new app.AsientoModel();

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.createAsientoView = new app.CreateAsientoView({ model: this.asientoModel });
            this.createAsientoView.render();
        },

        /**
        * show view show asiento contable
        */
        getAsientosShow: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.showAsientoView instanceof Backbone.View ){
                this.showAsientoView.stopListening();
                this.showAsientoView.undelegateEvents();
            }

            this.showAsientoView = new app.ShowAsientoView({ model: this.asientoModel });
        },

        /**
        * show view edit asiento contable
        */
        getAsientosEdit: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.editAsientoView instanceof Backbone.View ){
                this.editAsientoView.stopListening();
                this.editAsientoView.undelegateEvents();
            }

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.editAsientoView = new app.EditAsientoView({ model: this.asientoModel });
            this.asientoModel.fetch();
        },
        /**
        * show view main asiento NIF contable
        */
        getAsientosNifMain: function () {

            if ( this.mainAsientosNifView instanceof Backbone.View ){
                this.mainAsientosNifView.stopListening();
                this.mainAsientosNifView.undelegateEvents();
            }

            this.mainAsientosNifView = new app.MainAsientosNifView( );
        },
        /**
        * show view show asiento NIF contable
        */
        getAsientosNifShow: function (asientoNif) {
            this.asientoNifModel = new app.AsientoNifModel();
            this.asientoNifModel.set({'id': asientoNif}, {'silent':true});

            if ( this.showAsientoNifView instanceof Backbone.View ){
                this.showAsientoNifView.stopListening();
                this.showAsientoNifView.undelegateEvents();
            }

            this.showAsientoNifView = new app.ShowAsientoNifView({ model: this.asientoNifModel });
        },
        /**
        * show view edit asiento NIF contable
        */
        getAsientosNifEdit: function (asientoNif) {
            this.asientoNifModel = new app.AsientoNifModel();
            this.asientoNifModel.set({'id': asientoNif}, {'silent':true});

            if ( this.editAsientoNifView instanceof Backbone.View ){
                this.editAsientoNifView.stopListening();
                this.editAsientoNifView.undelegateEvents();
            }

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.editAsientoNifView = new app.EditAsientoNifView({ model: this.asientoNifModel });
            this.asientoNifModel.fetch();
        },
        /**
        * show view create cierre contable mensual
        */
        getCierreMensualCreate: function (){

            if ( this.createCierreContableMensualView instanceof Backbone.View ){
                this.createCierreContableMensualView.stopListening();
                this.createCierreContableMensualView.undelegateEvents();
            }

            this.createCierreContableMensualView = new app.CreateCierreContableMensualView();
            this.createCierreContableMensualView.render();
        },
        /**
        * show view show folders
        */
        getFoldersMain: function () {

            if ( this.mainFoldersView instanceof Backbone.View ){
                this.mainFoldersView.stopListening();
                this.mainFoldersView.undelegateEvents();
            }

            this.mainFoldersView = new app.MainFoldersView( );
        },

        /**
        * show view create folders
        */
        getFoldersCreate: function () {
            this.folderModel = new app.FolderModel();

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.createFolderView.render();
        },

        /**
        * show view edit folder
        */
        getFoldersEdit: function (folder) {
            this.folderModel = new app.FolderModel();
            this.folderModel.set({'id': folder}, {silent: true});

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.folderModel.fetch();
        },

        /**
        * show view main documentos
        */
        getDocumentosMain: function () {
            if ( this.mainDocumentosView instanceof Backbone.View ){
                this.mainDocumentosView.stopListening();
                this.mainDocumentosView.undelegateEvents();
            }

            this.mainDocumentosView = new app.MainDocumentosView( );
        },

        /**
        * show view create documento
        */
        getDocumentosCreate: function () {
            this.documentoModel = new app.DocumentoModel();

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.createDocumentoView.render();
        },

        /**
        * show view edit documento
        */
        getDocumentosEdit: function (documento) {
            this.documentoModel = new app.DocumentoModel();
            this.documentoModel.set({'id': documento}, {silent: true});

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.documentoModel.fetch();
        },

        /**
        * show view main subgrupos
        */
        getSubGruposMain: function () {

            if ( this.mainSubGruposView instanceof Backbone.View ){
                this.mainSubGruposView.stopListening();
                this.mainSubGruposView.undelegateEvents();
            }

            this.mainSubGruposView = new app.MainSubGruposView( );
        },

        /**
        * show view create subgrupo
        */
        getSubGruposCreate: function () {
            this.subGrupoModel = new app.SubGrupoModel();

            if ( this.createSubGrupoView instanceof Backbone.View ){
                this.createSubGrupoView.stopListening();
                this.createSubGrupoView.undelegateEvents();
            }

            this.createSubGrupoView = new app.CreateSubGrupoView({ model: this.subGrupoModel });
            this.createSubGrupoView.render();
        },

        /**
        * show view edit subgrupo
        */
        getSubGruposEdit: function (subgrupo) {
            this.subGrupoModel = new app.SubGrupoModel();
            this.subGrupoModel.set({'id': subgrupo}, {silent: true});

            if ( this.createSubGrupoView instanceof Backbone.View ){
                this.createSubGrupoView.stopListening();
                this.createSubGrupoView.undelegateEvents();
            }

            this.createSubGrupoView = new app.CreateSubGrupoView({ model: this.subGrupoModel });
            this.subGrupoModel.fetch();
        },

        /**
        * show view main grupos
        */
        getGruposMain: function () {

            if ( this.mainGruposView instanceof Backbone.View ){
                this.mainGruposView.stopListening();
                this.mainGruposView.undelegateEvents();
            }

            this.mainGruposView = new app.MainGruposView( );
        },

        /**
        * show view create grupo
        */
        getGruposCreate: function () {
            this.grupoModel = new app.GrupoModel();

            if ( this.createGrupoView instanceof Backbone.View ){
                this.createGrupoView.stopListening();
                this.createGrupoView.undelegateEvents();
            }

            this.createGrupoView = new app.CreateGrupoView({ model: this.grupoModel });
            this.createGrupoView.render();
        },

        /**
        * show view edit grupo
        */
        getGruposEdit: function (grupo) {
            this.grupoModel = new app.GrupoModel();
            this.grupoModel.set({'id': grupo}, {silent: true});

            if ( this.createGrupoView instanceof Backbone.View ){
                this.createGrupoView.stopListening();
                this.createGrupoView.undelegateEvents();
            }

            this.createGrupoView = new app.CreateGrupoView({ model: this.grupoModel });
            this.grupoModel.fetch();
        },

        /**
        * show view main unidades de medida
        */
        getUnidadesMain: function () {

            if ( this.mainUnidadesView instanceof Backbone.View ){
                this.mainUnidadesView.stopListening();
                this.mainUnidadesView.undelegateEvents();
            }

            this.mainUnidadesView = new app.MainUnidadesView( );
        },

        /**
        * show view create unidad de medida
        */
        getUnidadesCreate: function () {
            this.unidadModel = new app.UnidadModel();

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.createUnidadView.render();
        },

        /**
        * show view edit unidad de medida
        */
        getUnidadesEdit: function (unidad) {
            this.unidadModel = new app.UnidadModel();
            this.unidadModel.set({'id': unidad}, {silent: true});

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.unidadModel.fetch();
        },

        /**
        * show view main productos
        */
        getProductosMain: function () {

            if ( this.mainProductosView instanceof Backbone.View ){
                this.mainProductosView.stopListening();
                this.mainProductosView.undelegateEvents();
            }

            this.mainProductosView = new app.MainProductosView( );
        },

        /**
        * show view create producto
        */
        getProductosCreate: function () {
            this.productoModel = new app.ProductoModel();

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.createProductoView.render();
        },

        /**
        * show view show producto
        */
        getProductoShow: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {'silent':true});

            if ( this.showProductoView instanceof Backbone.View ){
                this.showProductoView.stopListening();
                this.showProductoView.undelegateEvents();
            }

            this.showProductoView = new app.ShowProductoView({ model: this.productoModel });
        },
        /**
        * show view edit producto
        */
        getProductosEdit: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {silent: true});

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.productoModel.fetch();
        },

        /**
        * show view main traslados
        */
        getTrasladosMain: function () {

            if ( this.mainTrasladosView instanceof Backbone.View ){
                this.mainTrasladosView.stopListening();
                this.mainTrasladosView.undelegateEvents();
            }

            this.mainTrasladosView = new app.MainTrasladosView( );
        },

        /**
        * show view create traslado
        */
        getTrasladosCreate: function () {
            this.trasladoModel = new app.TrasladoModel();

            if ( this.createTrasladoView instanceof Backbone.View ){
                this.createTrasladoView.stopListening();
                this.createTrasladoView.undelegateEvents();
            }

            this.createTrasladoView = new app.CreateTrasladoView({ model: this.trasladoModel });
            this.createTrasladoView.render();
        },

        /**
        * show view show traslado
        */
        getTrasladosShow: function (traslado) {
            this.trasladoModel = new app.TrasladoModel();
            this.trasladoModel.set({'id': traslado}, {'silent':true});

            if ( this.showTrasladoView instanceof Backbone.View ){
                this.showTrasladoView.stopListening();
                this.showTrasladoView.undelegateEvents();
            }

            this.showTrasladoView = new app.ShowTrasladoView({ model: this.trasladoModel });
        },

        /* ######################### Produccion #########################
        /**
        * show view main areas produccion
        */
        /**
        * show view edit tiempop
        */
        getTiempopMain: function () {
            this.tiempopModel = new app.TiempopModel();

            if ( this.mainTiempopView instanceof Backbone.View ){
                this.mainTiempopView.stopListening();
                this.mainTiempopView.undelegateEvents();
            }

            this.mainTiempopView = new app.MainTiempopView({ model: this.tiempopModel });
        },

        getReporteTiempospMain: function () {
            if ( this.mainReporteTiempospView instanceof Backbone.View ){
                this.mainReporteTiempospView.stopListening();
                this.mainReporteTiempospView.undelegateEvents();
            }

            this.mainReporteTiempospView = new app.MainReporteTiempospView();
        },

        getAreaspMain: function () {

            if ( this.mainAreaspView instanceof Backbone.View ){
                this.mainAreaspView.stopListening();
                this.mainAreaspView.undelegateEvents();
            }

            this.mainAreaspView = new app.MainAreaspView( );
        },

        /**
        * show view create areas de produccion
        */
        getAreaspCreate: function () {
            this.areapModel = new app.AreapModel();

            if ( this.createAreapView instanceof Backbone.View ){
                this.createAreapView.stopListening();
                this.createAreapView.undelegateEvents();
            }

            this.createAreapView = new app.CreateAreapView({ model: this.areapModel });
            this.createAreapView.render();
        },

        /**
        * show view edit areas de produccion
        */
        getAreaspEdit: function (areap) {
            this.areapModel = new app.AreapModel();
            this.areapModel.set({'id': areap}, {'silent':true});

            if ( this.createAreapView instanceof Backbone.View ){
                this.createAreapView.stopListening();
                this.createAreapView.undelegateEvents();
            }

            this.createAreapView = new app.CreateAreapView({ model: this.areapModel });
            this.areapModel.fetch();
        },

        /**
        * show view create actividades de produccion de produccion
        */
        getActividadespMain: function () {

            if ( this.mainActividadespView instanceof Backbone.View ){
                this.mainActividadespView.stopListening();
                this.mainActividadespView.undelegateEvents();
            }

            this.mainActividadespView = new app.MainActividadespView( );
        },

        /**
        * show view create actividades de produccion de produccion
        */
        getActividadespCreate: function () {
            this.actividadpModel = new app.ActividadpModel();

            if ( this.createActividadpView instanceof Backbone.View ){
                this.createActividadpView.stopListening();
                this.createActividadpView.undelegateEvents();
            }

            this.createActividadpView = new app.CreateActividadpView({ model: this.actividadpModel });
            this.createActividadpView.render();
        },

        /**
        * show view edit actividades de produccion de produccion
        */
        getActividadespEdit: function ( actividadp ) {
            this.actividadpModel = new app.ActividadpModel();
            this.actividadpModel.set({'id': actividadp}, {'silent':true});

            if ( this.createActividadpView instanceof Backbone.View ){
                this.createActividadpView.stopListening();
                this.createActividadpView.undelegateEvents();
            }

            this.createActividadpView = new app.CreateActividadpView({ model: this.actividadpModel });
            this.actividadpModel.fetch();
        },

        /**
        * show view create subactividades de produccion de produccion
        */
        getSubActividadespMain: function () {

            if ( this.mainSubActividadespView instanceof Backbone.View ){
                this.mainSubActividadespView.stopListening();
                this.mainSubActividadespView.undelegateEvents();
            }

            this.mainSubActividadespView = new app.MainSubActividadespView( );
        },

        /**
        * show view create subactividades de produccion de produccion
        */
        getSubActividadespCreate: function () {
            this.subactividadpModel = new app.SubActividadpModel();

            if ( this.createSubActividadpView instanceof Backbone.View ){
                this.createSubActividadpView.stopListening();
                this.createSubActividadpView.undelegateEvents();
            }

            this.createSubActividadpView = new app.CreateSubActividadpView({ model: this.subactividadpModel });
            this.createSubActividadpView.render();
        },

        /**
        * show view edit actividades de produccion de produccion
        */
        getSubActividadespEdit: function ( subactividadp ) {
            this.subactividadpModel = new app.SubActividadpModel();
            this.subactividadpModel.set({'id': subactividadp}, {'silent':true});

            if ( this.createSubActividadpView instanceof Backbone.View ){
                this.createSubActividadpView.stopListening();
                this.createSubActividadpView.undelegateEvents();
            }

            this.createSubActividadpView = new app.CreateSubActividadpView({ model: this.subactividadpModel });
            this.subactividadpModel.fetch();
        },

        /**
        * show view main acabados produccion
        */
        getAcabadospMain: function () {

            if ( this.mainAcabadospView instanceof Backbone.View ){
                this.mainAcabadospView.stopListening();
                this.mainAcabadospView.undelegateEvents();
            }

            this.mainAcabadospView = new app.MainAcabadospView( );
        },

        /**
        * show view create acabados de produccion
        */
        getAcabadospCreate: function () {
            this.acabadopModel = new app.AcabadopModel();

            if ( this.createAcabadospView instanceof Backbone.View ){
                this.createAcabadospView.stopListening();
                this.createAcabadospView.undelegateEvents();
            }

            this.createAcabadospView = new app.CreateAcabadospView({ model: this.acabadopModel });
            this.createAcabadospView.render();
        },

        /**
        * show view edit areas de produccion
        */
        getAcabadospEdit: function (acabado) {
            this.acabadopModel = new app.AcabadopModel();
            this.acabadopModel.set({'id': acabado}, {'silent':true});

            if ( this.createAcabadospView instanceof Backbone.View ){
                this.createAcabadospView.stopListening();
                this.createAcabadospView.undelegateEvents();
            }

            this.createAcabadospView = new app.CreateAcabadospView({ model: this.acabadopModel });
            this.acabadopModel.fetch();
        },

        /**
        * show view main maquinas produccion
        */
        getMaquinaspMain: function () {

            if ( this.mainMaquinaspView instanceof Backbone.View ){
                this.mainMaquinaspView.stopListening();
                this.mainMaquinaspView.undelegateEvents();
            }

            this.mainMaquinaspView = new app.MainMaquinaspView( );
        },

        /**
        * show view create maquinas de produccion
        */
        getMaquinaspCreate: function () {
            this.maquinapModel = new app.MaquinapModel();

            if ( this.createMaquinapView instanceof Backbone.View ){
                this.createMaquinapView.stopListening();
                this.createMaquinapView.undelegateEvents();
            }

            this.createMaquinapView = new app.CreateMaquinapView({ model: this.maquinapModel });
            this.createMaquinapView.render();
        },

        /**
        * show view edit maquinas de produccion
        */
        getMaquinaspEdit: function (maquinap) {
            this.maquinapModel = new app.MaquinapModel();
            this.maquinapModel.set({'id': maquinap}, {'silent':true});

            if ( this.createMaquinapView instanceof Backbone.View ){
                this.createMaquinapView.stopListening();
                this.createMaquinapView.undelegateEvents();
            }

            this.createMaquinapView = new app.CreateMaquinapView({ model: this.maquinapModel });
            this.maquinapModel.fetch();
        },

        /**
        * show view main materiales produccion
        */
        getMaterialespMain: function () {

            if ( this.mainMaterialespView instanceof Backbone.View ){
                this.mainMaterialespView.stopListening();
                this.mainMaterialespView.undelegateEvents();
            }

            this.mainMaterialespView = new app.MainMaterialespView( );
        },

        /**
        * show view create materiales de produccion
        */
        getMaterialespCreate: function () {
            this.materialpModel = new app.MaterialpModel();

            if ( this.createMaterialpView instanceof Backbone.View ){
                this.createMaterialpView.stopListening();
                this.createMaterialpView.undelegateEvents();
            }

            this.createMaterialpView = new app.CreateMaterialpView({ model: this.materialpModel });
            this.createMaterialpView.render();
        },

        /**
        * show view edit materiales de produccion
        */
        getMaterialespEdit: function (materialp) {
            this.materialpModel = new app.MaterialpModel();
            this.materialpModel.set({'id': materialp}, {'silent':true});

            if ( this.createMaterialpView instanceof Backbone.View ){
                this.createMaterialpView.stopListening();
                this.createMaterialpView.undelegateEvents();
            }

            this.createMaterialpView = new app.CreateMaterialpView({ model: this.materialpModel });
            this.materialpModel.fetch();
        },

        /**
        * show view main tipos de material produccion
        */
        getTipoMaterialespMain: function () {

            if ( this.mainTipoMaterialespView instanceof Backbone.View ){
                this.mainTipoMaterialespView.stopListening();
                this.mainTipoMaterialespView.undelegateEvents();
            }

            this.mainTipoMaterialespView = new app.MainTipoMaterialespView( );
        },

        /**
        * show view create tipos de material de produccion
        */
        getTipoMaterialpCreate: function () {
            this.tipomaterialpModel = new app.TipoMaterialpModel();

            if ( this.createTipoMaterialpView instanceof Backbone.View ){
                this.createTipoMaterialpView.stopListening();
                this.createTipoMaterialpView.undelegateEvents();
            }

            this.createTipoMaterialpView = new app.CreateTipoMaterialpView({ model: this.tipomaterialpModel });
            this.createTipoMaterialpView.render();
        },

        /**
        * show view edit tipos de material de produccion
        */
        getTipoMaterialpEdit: function (tipomaterialp) {
            this.tipomaterialpModel = new app.TipoMaterialpModel();
            this.tipomaterialpModel.set({'id': tipomaterialp}, {'silent':true});

            if ( this.createTipoMaterialpView instanceof Backbone.View ){
                this.createTipoMaterialpView.stopListening();
                this.createTipoMaterialpView.undelegateEvents();
            }

            this.createTipoMaterialpView = new app.CreateTipoMaterialpView({ model: this.tipomaterialpModel });
            this.tipomaterialpModel.fetch();
        },

        /**
        * show view main tipos de producto produccion
        */
        getTipoProductopMain: function () {

            if ( this.mainTipoProductospView instanceof Backbone.View ){
                this.mainTipoProductospView.stopListening();
                this.mainTipoProductospView.undelegateEvents();
            }

            this.mainTipoProductospView = new app.MainTipoProductospView( );
        },

        /**
        * show view create tipos de producto de produccion
        */
        getTipoProductopCreate: function () {
            this.tipoproductopModel = new app.TipoProductopModel();

            if ( this.createTipoProductopView instanceof Backbone.View ){
                this.createTipoProductopView.stopListening();
                this.createTipoProductopView.undelegateEvents();
            }

            this.createTipoProductopView = new app.CreateTipoProductopView({ model: this.tipoproductopModel });
            this.createTipoProductopView.render();
        },

        /**
        * show view edit tipos de producto de produccion
        */
        getTipoProductopEdit: function ( tipoproductosp ) {
            this.tipoproductopModel = new app.TipoProductopModel();
            this.tipoproductopModel.set({'id': tipoproductosp }, {'silent':true});

            if ( this.createTipoProductopView instanceof Backbone.View ){
                this.createTipoProductopView.stopListening();
                this.createTipoProductopView.undelegateEvents();
            }

            this.createTipoProductopView = new app.CreateTipoProductopView({ model: this.tipoproductopModel });
            this.tipoproductopModel.fetch();
        },

        /**
        * show view main subtipos de producto produccion
        */
        getSubtipoProductopMain: function () {

            if ( this.mainSubtipoProductospView instanceof Backbone.View ){
                this.mainSubtipoProductospView.stopListening();
                this.mainSubtipoProductospView.undelegateEvents();
            }

            this.mainSubtipoProductospView = new app.MainSubtipoProductospView( );
        },

        /**
        * show view create subtipos de producto de produccion
        */
        getSubtipoProductopCreate: function () {
            this.subtipoproductopModel = new app.SubtipoProductopModel();

            if ( this.createSubtipoProductopView instanceof Backbone.View ){
                this.createSubtipoProductopView.stopListening();
                this.createSubtipoProductopView.undelegateEvents();
            }

            this.createSubtipoProductopView = new app.CreateSubtipoProductopView({ model: this.subtipoproductopModel });
            this.createSubtipoProductopView.render();
        },

        /**
        * show view edit subtipos de producto de produccion
        */
        getSubtipoProductopEdit: function ( subtipoproductosp ) {
            this.subtipoproductopModel = new app.SubtipoProductopModel();
            this.subtipoproductopModel.set({'id': subtipoproductosp }, {'silent':true});

            if ( this.createSubtipoProductopView instanceof Backbone.View ){
                this.createSubtipoProductopView.stopListening();
                this.createSubtipoProductopView.undelegateEvents();
            }

            this.createSubtipoProductopView = new app.CreateSubtipoProductopView({ model: this.subtipoproductopModel });
            this.subtipoproductopModel.fetch();
        },

        /**
        * show view main ordenes de produccion
        */
        getOrdenesMain: function () {
            if ( this.mainOrdenesView instanceof Backbone.View ){
                this.mainOrdenesView.stopListening();
                this.mainOrdenesView.undelegateEvents();
            }

            this.mainOrdenesView = new app.MainOrdenesView( );
        },

        /**
        * show view create ordenes de produccion
        */
        getOrdenesCreate: function () {
            this.ordenpModel = new app.OrdenpModel();

            if ( this.createOrdenpView instanceof Backbone.View ){
                this.createOrdenpView.stopListening();
                this.createOrdenpView.undelegateEvents();
            }

            this.createOrdenpView = new app.CreateOrdenpView({ model: this.ordenpModel });
            this.createOrdenpView.render();
        },

        /**
        * show view show orden
        */
        getOrdenesShow: function (orden) {
            this.ordenpModel = new app.OrdenpModel();
            this.ordenpModel.set({'id': orden}, {'silent':true});

            if ( this.showOrdenesView instanceof Backbone.View ){
                this.showOrdenesView.stopListening();
                this.showOrdenesView.undelegateEvents();
            }

            this.showOrdenesView = new app.ShowOrdenesView({ model: this.ordenpModel });
        },

        /**
        * show view edit ordenes
        */
        getOrdenesEdit: function (orden) {
            this.ordenpModel = new app.OrdenpModel();
            this.ordenpModel.set({'id': orden}, {'silent':true});

            if ( this.createOrdenpView instanceof Backbone.View ){
                this.createOrdenpView.stopListening();
                this.createOrdenpView.undelegateEvents();
            }

            if ( this.editOrdenpView instanceof Backbone.View ){
                this.editOrdenpView.stopListening();
                this.editOrdenpView.undelegateEvents();
            }

            this.editOrdenpView = new app.EditOrdenpView({ model: this.ordenpModel });
            this.ordenpModel.fetch();
        },

        /**
        * show view main productos produccion
        */
        getProductospMain: function () {

            if ( this.mainProductospView instanceof Backbone.View ){
                this.mainProductospView.stopListening();
                this.mainProductospView.undelegateEvents();
            }

            this.mainProductospView = new app.MainProductospView( );
        },

        /**
        * show view create productos en ordenes de produccion
        */
        getOrdenesProductoCreate: function (queryString) {
            var queries = this.parseQueryString(queryString);
            this.ordenp2Model = new app.Ordenp2Model();

            if ( this.createOrdenp2View instanceof Backbone.View ){
                this.createOrdenp2View.stopListening();
                this.createOrdenp2View.undelegateEvents();
            }

            this.createOrdenp2View = new app.CreateOrdenp2View({
                model: this.ordenp2Model,
                parameters: {
                    data : {
                        orden2_orden: queries.ordenp,
                        orden2_productop: queries.productop
                    }
                }
            });
            this.createOrdenp2View.render();
        },

        /**
        * show view edit ordenes
        */
        getOrdenesProductoEdit: function (producto) {
            this.ordenp2Model = new app.Ordenp2Model();
            this.ordenp2Model.set({'id': producto}, {'silent':true});

            if ( this.createOrdenp2View instanceof Backbone.View ){
                this.createOrdenp2View.stopListening();
                this.createOrdenp2View.undelegateEvents();
            }

            this.createOrdenp2View = new app.CreateOrdenp2View({ model: this.ordenp2Model });
            this.ordenp2Model.fetch();
        },

        /**
        * show view edit ordeenes
        */
        getOrdenesProductoShow: function (producto) {
            this.ordenp2Model = new app.Ordenp2Model();
            this.ordenp2Model.set({'id': producto}, {'silent':true});

            if ( this.showOrdenp2View instanceof Backbone.View ){
                this.showOrdenp2View.stopListening();
                this.showOrdenp2View.undelegateEvents();
            }

            this.showOrdenp2View = new app.ShowOrdenp2View({ model: this.ordenp2Model });
        },

        /**
        * show view create productos produccion
        */
        getProductospCreate: function () {
            this.productopModel = new app.ProductopModel();

            if ( this.createProductopView instanceof Backbone.View ){
                this.createProductopView.stopListening();
                this.createProductopView.undelegateEvents();
            }

            this.createProductopView = new app.CreateProductopView({ model: this.productopModel });
            this.createProductopView.render();
        },

        /**
        * show view show tercero
        */
        getProductospShow: function (producto) {
            this.productopModel = new app.ProductopModel();
            this.productopModel.set({'id': producto}, {silent: true});

            if ( this.showProductopView instanceof Backbone.View ){
                this.showProductopView.stopListening();
                this.showProductopView.undelegateEvents();
            }

            this.showProductopView = new app.ShowProductopView({ model: this.productopModel });
        },

        /**
        * show view edit productos produccion
        */
        getProductospEdit: function (producto) {
            this.productopModel = new app.ProductopModel();
            this.productopModel.set({'id': producto}, {silent: true});

            if ( this.createProductopView instanceof Backbone.View ){
                this.createProductopView.stopListening();
                this.createProductopView.undelegateEvents();
            }

            if ( this.editProductopView instanceof Backbone.View ){
                this.editProductopView.stopListening();
                this.editProductopView.undelegateEvents();
            }

            this.editProductopView = new app.EditProductopView({ model: this.productopModel });
            this.productopModel.fetch();
        },

        /**
        * show view main precotizacion
        */
        getPreCotizacionesMain: function () {

            if ( this.mainPreCotizacionesView instanceof Backbone.View ){
                this.mainPreCotizacionesView.stopListening();
                this.mainPreCotizacionesView.undelegateEvents();
            }

            this.mainPreCotizacionesView = new app.MainPreCotizacionesView( );
        },

        /**
        * show view create precotizacion
        */
        getPreCotizacionesCreate: function () {
            this.precotizacionModel = new app.PreCotizacionModel();

            if ( this.createPreCotizacionView instanceof Backbone.View ){
                this.createPreCotizacionView.stopListening();
                this.createPreCotizacionView.undelegateEvents();
            }

            this.createPreCotizacionView = new app.CreatePreCotizacionView({ model: this.precotizacionModel });
            this.createPreCotizacionView.render();
        },

        /**
        * show view show precotizaicon
        */
        getPreCotizacionesShow: function (precotizacion) {
            this.precotizacionModel = new app.PreCotizacionModel();
            this.precotizacionModel.set({'id': precotizacion}, {silent: true});

            if ( this.showPreCotizacionView instanceof Backbone.View ){
                this.showPreCotizacionView.stopListening();
                this.showPreCotizacionView.undelegateEvents();
            }

            this.showPreCotizacionView = new app.ShowPreCotizacionView({ model: this.precotizacionModel });
        },

        /**
        * show view edit precotizacion produccion
        */
        getPreCotizacionesEdit: function (precotizacion) {
            this.precotizacionModel = new app.PreCotizacionModel();
            this.precotizacionModel.set({'id': precotizacion}, {'silent':true});

            if ( this.editPreCotizacionView instanceof Backbone.View ){
                this.editPreCotizacionView.stopListening();
                this.editPreCotizacionView.undelegateEvents();
            }

            if ( this.createPreCotizacionView instanceof Backbone.View ){
                this.createPreCotizacionView.stopListening();
                this.createPreCotizacionView.undelegateEvents();
            }

            this.editPreCotizacionView = new app.EditPreCotizacionView({ model: this.precotizacionModel });
            this.precotizacionModel.fetch();
        },

        /**
        * show view create productos en precotizaciones
        */
        getPreCotizacionesProductoCreate: function (queryString) {
            var queries = this.parseQueryString(queryString);
            this.precotizacion2Model = new app.PreCotizacion2Model();

            if ( this.createPreCotizacion2View instanceof Backbone.View ){
                this.createPreCotizacion2View.stopListening();
                this.createPreCotizacion2View.undelegateEvents();
            }

            this.createPreCotizacion2View = new app.CreatePreCotizacion2View({
                model: this.precotizacion2Model,
                parameters: {
                    data : {
                        precotizacion2_precotizacion1: queries.precotizacion,
                        precotizacion2_productop: queries.productop
                    }
                }
            });
            this.createPreCotizacion2View.render();
        },

        /**
        * show view edit cotizaciones
        */
        getPreCotizacionesProductoShow: function (producto) {
            this.precotizacion2Model = new app.PreCotizacion2Model();
            this.precotizacion2Model.set({'id': producto}, {'silent':true});

            if ( this.showPreCotizacion2View instanceof Backbone.View ){
                this.showPreCotizacion2View.stopListening();
                this.showPreCotizacion2View.undelegateEvents();
            }

            this.showPreCotizacion2View = new app.ShowPreCotizacion2View({ model: this.precotizacion2Model });
        },

        /**
        * show view edit cotizaciones
        */
        getPreCotizacionesProductoEdit: function (producto) {
            this.precotizacion2Model = new app.PreCotizacion2Model();
            this.precotizacion2Model.set({'id': producto}, {'silent':true});

            if ( this.createPreCotizacion2View instanceof Backbone.View ){
                this.createPreCotizacion2View.stopListening();
                this.createPreCotizacion2View.undelegateEvents();
            }

            this.createPreCotizacion2View = new app.CreatePreCotizacion2View({ model: this.precotizacion2Model });
            this.precotizacion2Model.fetch();
        },

        /**
        * show view main cotizacion produccion
        */
        getCotizacionesMain: function () {

            if ( this.mainCotizacionesView instanceof Backbone.View ){
                this.mainCotizacionesView.stopListening();
                this.mainCotizacionesView.undelegateEvents();
            }

            this.mainCotizacionesView = new app.MainCotizacionesView( );
        },

        /**
        * show view create cotizacion produccion
        */
        getCotizacionesCreate: function () {
            this.cotizacionModel = new app.CotizacionModel();

            if ( this.createCotizacionView instanceof Backbone.View ){
                this.createCotizacionView.stopListening();
                this.createCotizacionView.undelegateEvents();
            }

            this.createCotizacionView = new app.CreateCotizacionView({ model: this.cotizacionModel });
            this.createCotizacionView.render();
        },

        /**
        * show view show tercero
        */
        getCotizacionesShow: function (cotizacion) {
            this.cotizacionModel = new app.CotizacionModel();
            this.cotizacionModel.set({'id': cotizacion}, {silent: true});

            if ( this.showCotizacionView instanceof Backbone.View ){
                this.showCotizacionView.stopListening();
                this.showCotizacionView.undelegateEvents();
            }

            this.showCotizacionView = new app.ShowCotizacionView({ model: this.cotizacionModel });
        },

        /**
        * show view edit cotizacion produccion
        */
        getCotizacionesEdit: function (cotizacion) {
            this.cotizacionModel = new app.CotizacionModel();
            this.cotizacionModel.set({'id': cotizacion}, {'silent':true});

            if ( this.editCotizacionView instanceof Backbone.View ){
                this.editCotizacionView.stopListening();
                this.editCotizacionView.undelegateEvents();
            }

            if ( this.createCotizacionView instanceof Backbone.View ){
                this.createCotizacionView.stopListening();
                this.createCotizacionView.undelegateEvents();
            }

            this.editCotizacionView = new app.EditCotizacionView({ model: this.cotizacionModel });
            this.cotizacionModel.fetch();
        },

        /**
        * show view create productos en cotizaciones
        */
        getCotizacionesProductoCreate: function (queryString) {
            var queries = this.parseQueryString(queryString);
            this.cotizacion2Model = new app.Cotizacion2Model();

            if ( this.createCotizacion2View instanceof Backbone.View ){
                this.createCotizacion2View.stopListening();
                this.createCotizacion2View.undelegateEvents();
            }

            this.createCotizacion2View = new app.CreateCotizacion2View({
                model: this.cotizacion2Model,
                parameters: {
                    data : {
                        cotizacion2_cotizacion: queries.cotizacion,
                        cotizacion2_productop: queries.productop
                    }
                }
            });
            this.createCotizacion2View.render();
        },

        /**
        * show view edit cotizaciones
        */
        getCotizacionesProductoEdit: function (producto) {
            this.cotizacion2Model = new app.Cotizacion2Model();
            this.cotizacion2Model.set({'id': producto}, {'silent':true});

            if ( this.createCotizacion2View instanceof Backbone.View ){
                this.createCotizacion2View.stopListening();
                this.createCotizacion2View.undelegateEvents();
            }

            this.createCotizacion2View = new app.CreateCotizacion2View({ model: this.cotizacion2Model });
            this.cotizacion2Model.fetch();
        },

        /**
        * show view edit cotizaciones
        */
        getCotizacionesProductoShow: function (producto) {
            this.cotizacion2Model = new app.Cotizacion2Model();
            this.cotizacion2Model.set({'id': producto}, {'silent':true});

            if ( this.showCotizacion2View instanceof Backbone.View ){
                this.showCotizacion2View.stopListening();
                this.showCotizacion2View.undelegateEvents();
            }

            this.showCotizacion2View = new app.ShowCotizacion2View({ model: this.cotizacion2Model });
        },

        /**
        * Cartera
        */

        // Facturas
        getFacturasMain: function () {

            if ( this.mainFacturaView instanceof Backbone.View ){
                this.mainFacturaView.stopListening();
                this.mainFacturaView.undelegateEvents();
            }

            this.mainFacturaView = new app.MainFacturasView( );
        },

        getFacturaCreate: function () {
            this.facturaModel = new app.FacturaModel();
            if ( this.createFacturaView instanceof Backbone.View ){
                this.createFacturaView.stopListening();
                this.createFacturaView.undelegateEvents();
            }

            this.createFacturaView = new app.CreateFacturaView({ model: this.facturaModel });
            this.createFacturaView.render();
        },

        getFacturaShow: function(facturas){
            this.facturaModel = new app.FacturaModel();
            this.facturaModel.set({'id': facturas}, {'silent':true});
            if ( this.showFacturasView instanceof Backbone.View ){
                this.showFacturasView.stopListening();
                this.showFacturasView.undelegateEvents();
            }

            this.showFacturasView = new app.ShowFacturaView({ model: this.facturaModel });
        },

        /**
        * Treasury
        */
        getFacturaspMain: function() {
            if ( this.mainFacturaspView instanceof Backbone.View ){
                this.mainFacturaspView.stopListening();
                this.mainFacturaspView.undelegateEvents();
            }

            this.mainFacturaspView = new app.MainFacturaspView();
        },

        getFacturaspShow: function(facturap){
            this.facturapModel = new app.FacturapModel();
            this.facturapModel.set({'id': facturap}, {'silent':true});

            if( this.showFacturapView instanceof Backbone.View ){
                this.showFacturapView.stopListening();
                this.showFacturapView.undelegateEvents();
            }

            this.showFacturapView = new app.ShowFacturapView({ model: this.facturapModel });
        },
    }) );

})(jQuery, this, this.document);
