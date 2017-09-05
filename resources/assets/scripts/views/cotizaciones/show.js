/**
* Class ShowCotizacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-show',
        events: {
            'click .export-cotizacion': 'exportCotizacion',
            'click .open-cotizacion': 'openCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Recuperar iva
            this.$iva = this.$('#cotizacion1_iva');

            // Attributes
            this.productopCotizacionList = new app.ProductopCotizacionList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView( {
                collection: this.productopCotizacionList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-cotizacion'),
                    iva: this.$iva.val(),
                    dataFilter: {
                        'cotizacion2_cotizacion': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Open cotizacion
        */
        openCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir cotización',
                    onConfirm: function () {
                        // Open cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.abrir', { cotizaciones: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
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
                data = { cotizacion_codigo: this.model.get('id') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneCotizacion({
                            'data': data,
                            'wrap': _this.$el,
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
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.model.get('id') })), '_blank');
        }
    });

})(jQuery, this, this.document);
