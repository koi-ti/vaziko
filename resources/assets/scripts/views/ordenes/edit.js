/**
* Class EditOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditOrdenpView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-ordenp-tpl').html() || '') ),
        events: {
            'click .submit-ordenp': 'submitOrdenp',
            'click .close-ordenp': 'closeOrdenp',
            'click .clone-ordenp': 'cloneOrdenp',
            'click .export-ordenp': 'exportOrdenp',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-ordenes': 'onStore',
            'submit #form-despachosp': 'onStoreDespacho'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.productopOrdenList = new app.ProductopOrdenList();
            this.despachopOrdenList = new app.DespachopOrdenList();
            this.despachospPendientesOrdenList = new app.DespachospPendientesOrdenList();
            this.asientoCuentasList = new app.AsientoCuentasList();
            // Tiempop general
            this.tiempopList = new app.TiempopList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-ordenes');
            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.spinner = this.$('#spinner-main');

            // Reference views and ready
            this.referenceViews();
            this.referenceCharts();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopOrdenListView = new app.ProductopOrdenListView( {
                collection: this.productopOrdenList,
                parameters: {
                    edit: true,
                    iva: this.model.get('orden_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos pendientes list
            this.despachospPendientesOrdenListView = new app.DespachospPendientesOrdenListView( {
                collection: this.despachospPendientesOrdenList,
                parameters: {
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Tiemposp  list
            this.tiempopListView = new app.TiempopListView( {
                collection: this.tiempopList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        type: 'ordenp',
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos list
            this.despachopOrdenListView = new app.DespachopOrdenListView( {
                collection: this.despachopOrdenList,
                parameters: {
                    edit: true,
                    wrapper: this.spinner,
                    collectionPendientes: this.despachospPendientesOrdenList,
                    dataFilter: {
                        despachop1_orden: this.model.get('id')
                    }
               }
            });

            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Event submit productop
        */
        submitOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create despacho
        */
        onStoreDespacho: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.despachop1_orden = this.model.get('id');
                this.despachopOrdenList.trigger( 'store', data );
            }
        },

        /**
        *   Event change select2 type orden
        **/
        changeTypeProduct: function(e) {
            var _this = this,
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).attr('disabled', 'disabled');
                    _this.$subtypeproduct.empty().val(0).removeAttr('disabled');
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0).attr('disabled', 'disabled');
                this.$product.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        *   Event change select2 subtype orden
        **/
        changeSubtypeProduct: function(e) {
            var _this = this,
                subtypeproduct = this.$(e.currentTarget).val(),
                typeproduct = this.$('#typeproductop').val();

            if( typeof(subtypeproduct) !== 'undefined' && !_.isUndefined(subtypeproduct) && !_.isNull(subtypeproduct) && subtypeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: {
                        subtypeproduct: subtypeproduct,
                        typeproduct: typeproduct
                    },
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).removeAttr('disabled');
                    _this.$product.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$product.append("<option value="+item.id+">"+item.productop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * export to PDF
        */
        exportOrdenp: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('ordenes.exportar', { ordenes: this.model.get('id') })), '_blank');
        },

        /**
        * Close ordenp
        */
        closeOrdenp: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.cerrar', { ordenes: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.spinner );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.spinner );

                            if(!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Clone ordenp
        */
        cloneOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: this.model.get('id') }) ),
                data = { orden_codigo: this.model.get('orden_codigo') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        referenceCharts: function (){
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'ordenes.tiemposp.charts.index' ) ),
                type: 'GET',
                data: {
                    orden_id: _this.model.id
                },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinnerCalendar );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinnerCalendar );
                if(!_.isUndefined(resp.success)) {
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }
                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }

                    // Render calendar
                    _this.charts( resp );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinnerCalendar );
                alertify.error(thrownError);
            });

        },

        charts: function ( datos ){
            var ctx = this.$('.chart-line').get(0).getContext('2d');
            var chartbar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.chartempleado.labels,
                    datasets: [{
                        label: '# de minutos gastados',
                        data: datos.chartempleado.data,
                        backgroundColor: '#00a65a',
                        strokeColor: '#00a65a',
                        pointColor: '#00a65a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                         xAxes: [{
                              display: true,
                              ticks: {
                                  fontColor: 'black',
                                  fontStyle: 'bold',
                                  fontSize: 9
                              }
                          }]
                    }
                }
            });

            var gradients = [];
            var r = 0, g = 100, b = 0, a = 1;
            for (i = 0; i < 150; i++) {
                // Verde
                if (i >= 25 && i < 50) r -= 10.2;

                var x = "rgba(" + Math.floor(r) + "," + Math.floor(g) + "," + Math.floor(b) + "," + a + ")";
                gradients.push(x);
                a -= 0.1;
            }

            var ctx = this.$('.chart-donut').get(0).getContext('2d');
            var chartpie = new Chart(ctx ,{
                type: 'doughnut',
                data: {
                    labels: datos.chartareap.labels,
                    datasets: [{
                        backgroundColor: gradients,
                        data: datos.chartareap.data
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'A continuación se muestra el tiempo en minutos empleado por área.'
                    },
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            fontColor: 'black',
                            fontStyle: 'bold',
                            fontSize: 9
                        }
                    }
                }
            });

            this.$('.tiempo-total').text(datos.tiempototal);
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // Redirect to edit orden
                window.Misc.redirect( window.Misc.urlFull( Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);
