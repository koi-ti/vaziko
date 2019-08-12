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
        initialize: function () {
            // Recuperar iva && cotizacion codigo
            this.$iva = this.$('#cotizacion1_iva');
            this.codigo = this.$('#cotizacion_codigo').val();
            this.$renderChartProductos = this.$('#render-chart-cotizacion');

            // Attributes
            this.productopCotizacionList = new app.ProductopCotizacionList();

            // Reference views
            this.referenceCharts();
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
                route = window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
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
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.codigo })), '_blank');
        },

        /**
        * Reference charts
        */
        referenceCharts: function () {
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.charts', {cotizaciones: _this.model.get('id')})),
                type: 'GET',
                beforeSend: function () {
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

                    // Render calendar
                    _this.charts(resp);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner(_this.spinner);
                alertify.error(thrownError);
            });

        },

        /**
        * Charts
        */
        charts: function (resp) {
            // Definir opciones globales para graficas del modulo
            Chart.defaults.global.defaultFontColor="black";
            Chart.defaults.global.defaultFontSize=12;
            Chart.defaults.global.title.fontSize=14;

            // Charts productos
            if (!_.isEmpty(resp.chartproductos.data)) {
                var ctx = this.$('#chart_producto').get(0).getContext('2d');

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            backgroundColor: [
                                '#CD5C5C', '#F08080', '#FA8072', '#E9967A', '#FFA07A', '#DC143C'
                            ],
                            data: resp.chartproductos.data
                        }],
                        labels: resp.chartproductos.labels
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        legend: {
                            display: true,
                            position: 'right',
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    return data.labels[item.index] + ": " + window.Misc.currency(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        }
                    },
                });
            }
        },
    });

})(jQuery, this, this.document);
