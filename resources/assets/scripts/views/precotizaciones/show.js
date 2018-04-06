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
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // precotizacion codigo
            this.codigo = this.$('#precotizacion_codigo').val();

            // Attributes
            this.productopPreCotizacionList = new app.ProductopPreCotizacionList();

            // Reference views
            this.referenceViews();
        },

        /**
        * Open pre-cotizacion
        */
        openPreCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { precotizacion_codigo: _this.model.get('precotizacion_codigo') },
                    template: _.template( ($('#precotizaciones-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir pre-cotización',
                    onConfirm: function () {
                        // Open pre-cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('precotizaciones.abrir', { precotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: _this.model.get('id') })) );
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
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopPreCotizacionListView = new app.ProductopPreCotizacionListView( {
                collection: this.productopPreCotizacionList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-precotizacion'),
                    dataFilter: {
                        'precotizacion2_precotizacion1': this.model.get('id')
                    }
               }
            });
        },
    });

})(jQuery, this, this.document);
