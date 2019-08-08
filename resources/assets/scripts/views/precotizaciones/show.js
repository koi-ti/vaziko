/**
* Class ShowPreCotizacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowPreCotizacionView = Backbone.View.extend({

        el: '#precotizaciones-show',
        events: {
            'click .open-precotizacion': 'openPreCotizacion',
            'click .clone-precotizacion': 'clonePreCotizacion',
            'click .generate-precotizacion': 'generatePreCotizacion',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // precotizacion codigo
            this.codigo = this.$('#precotizacion_codigo').val();

            // Attributes
            this.productopPreCotizacionList = new app.ProductopPreCotizacionList();
            this.spinner = this.$('.spinner-main');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopPreCotizacionListView = new app.ProductopPreCotizacionListView( {
                collection: this.productopPreCotizacionList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        precotizacion: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Open pre-cotizacion
        */
        openPreCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: {
                        precotizacion_codigo: _this.model.get('precotizacion_codigo')
                    },
                    template: _.template( ($('#precotizaciones-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir pre-cotización',
                    onConfirm: function () {
                        // Open pre-cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('precotizaciones.abrir', { precotizaciones: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner(_this.spinner);
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner(_this.spinner);
                            if (!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if (_.isObject(resp.errors)) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if (!resp.success) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('precotizaciones.edit', {precotizaciones: _this.model.get('id') })));
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
        * Clone precotizacion
        */
        clonePreCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('precotizaciones.clonar', { precotizaciones: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#precotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar pre-cotización',
                    onConfirm: function () {
                        // Clone precotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp ) {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route('precotizaciones.edit', { precotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Generate pre-cotizacion
        */
        generatePreCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
                route =  window.Misc.urlFull( Route.route('precotizaciones.generar', { precotizaciones: this.model.get('id') }) );

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#precotizacion-generate-confirm-tpl').html() || '') ),
                    titleConfirm: 'Generar cotización',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: route,
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

                                // Redireccionar a cotizacion cuando todo este !OK
                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.cotizacion_id })) );
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
    });

})(jQuery, this, this.document);
