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
            'click .open-cotizacion': 'openCotizacion',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
             
                this.detalleCotizacion2 = new app.DetalleCotizacion2List();
                this.detalleCotizacion3 = new app.DetalleCotizacion3List();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle cotizacion2 list
            this.detalleCotizacion2ListView = new app.DetalleCotizacion2ListView({
                collection: this.detalleCotizacion2,
                parameters: {
                    wrapper: this.el,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });

            // Detalle cotizacion3 list
            this.detalleCotizacion3ListView = new app.DetalleCotizacion3ListView({
                collection: this.detalleCotizacion3,
                parameters: {
                    wrapper: this.el,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });
        },

        openCotizacion: function(e){
            e.preventDefault();

            var _this = this;
            var openCotizacion = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabrir cotizacion',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.open', { cotizaciones: _this.model.get('id') }) ),
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

            openCotizacion.render();
        },
    });

})(jQuery, this, this.document);
