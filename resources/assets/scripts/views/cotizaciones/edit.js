/**
* Class EditCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'click .close-cotizacion': 'closeCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion',
            'click .generate-cotizacion': 'generateCotizacion',
            'click .export-cotizacion': 'exportCotizacion',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-cotizaciones': 'onStore',
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

            this.productopCotizacionList = new app.ProductopCotizacionList();

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

            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.$form = this.$('#form-cotizaciones');
            this.spinner = this.$('#spinner-main');

            // Reference views and ready
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView( {
                collection: this.productopCotizacionList,
                parameters: {
                    edit: true,
                    iva: this.model.get('cotizacion1_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        'cotizacion2_cotizacion': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit productop
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        changeTypeProduct: function(e) {
            var _this = this;
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

        changeSubtypeProduct: function(e) {
            var _this = this;
                subtypeproduct = this.$(e.currentTarget).val();
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
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.model.get('cotizacion_codigo') })), '_blank');
        },

        /**
        * Close cotizacion
        */
        closeCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar cotización',
                    onConfirm: function () {
                        // Close cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.cerrar', { cotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.show', { cotizaciones: _this.model.get('id') })) );
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
        * Clone cotizacion
        */
        cloneCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route =  window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: this.model.get('id') }) ),
                data = { cotizacion_codigo: _this.model.get('cotizacion_codigo') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Generate cotizacion
        */
        generateCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route =  window.Misc.urlFull( Route.route('cotizaciones.generar', { cotizaciones: this.model.get('id') }) ),
                data = { cotizacion_codigo: _this.model.get('cotizacion_codigo'), cotizacion_referencia: _this.model.get('cotizacion1_referencia') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-generate-confirm-tpl').html() || '') ),
                    titleConfirm: 'Generar orden de producción',
                    onConfirm: function () {
                        // Generate orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.generar', { cotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.orden_id })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cloneConfirm.render();
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

                // Redirect to edit cotizacion
                window.Misc.redirect( window.Misc.urlFull( Route.route('cotizaciones.edit', { cotizaciones: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);
