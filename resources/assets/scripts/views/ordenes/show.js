/**
* Class ShowOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowOrdenesView = Backbone.View.extend({

        el: '#ordenes-show',
        events: {
            'click .export-ordenp': 'exportOrdenp',
            'click .open-ordenp': 'openOrdenp',
            'click .clone-ordenp': 'cloneOrdenp'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$iva = this.$('#orden_iva');

            this.productopOrdenList = new app.ProductopOrdenList();
            this.despachopOrdenList = new app.DespachopOrdenList();
            this.tiempopList = new app.TiempopList();

            // Reference views
            this.referenceViews();
            this.referenceCharts();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopOrdenListView = new app.ProductopOrdenListView( {
                collection: this.productopOrdenList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-orden'),
                    iva: this.$iva.val(),
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos list
            this.despachopOrdenListView = new app.DespachopOrdenListView( {
                collection: this.despachopOrdenList,
                parameters: {
                    wrapper: this.$el,
                    dataFilter: {
                        despachop1_orden: this.model.get('id')
                    }
               }
            });

            // TiempopOrdenesp list
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
        },

        /**
        * Open ordenp
        */
        openOrdenp: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir orden de producción',
                    onConfirm: function () {
                        // Open orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.abrir', { ordenes: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: _this.model.get('id') })) );
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
        * Clone ordenp
        */
        cloneOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.$el,
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

        /**
        * export to PDF
        */
        exportOrdenp: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('ordenes.exportar', { ordenes: this.model.get('id') })), '_blank');
        },

        referenceCharts: function (){
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.charts', { ordenes: _this.model.get('id') }) ),
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

                    // Render calendar
                    _this.charts( resp );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });

        },

        charts: function ( datos ){
            var ctx = this.$('.chart-line').get(0).getContext('2d');
            var green_black_gradient = ctx.createLinearGradient(0, 0, 0, 300);
                green_black_gradient.addColorStop(0, 'green');
                green_black_gradient.addColorStop(1, 'black');

            var chartbar = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'minutos gastados',
                        data: datos.chartempleado.data,
                        backgroundColor: green_black_gradient,
                        hoverBackgroundColor: green_black_gradient,
                        strokeColor: 'yellow',
                        hoverBorderWidth: 2,
						hoverBorderColor: 'white'
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Tiempo gastado por empleado.'
                    },
                    legend: { display: false },
                    scales: {
                        xAxes: [{
                            type: 'category',
                            labels: datos.chartempleado.labels,
                            stacked: true,
                            barPercentage: 1.,
                            categoryPercentage: .5,
                            ticks: {
                                fontColor: 'black',
                                fontStyle: 'bold',
                                fontSize: 9
                            },
                            gridLines: {
                                offsetGridLines: true
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                fontColor: 'black',
                                fontStyle: 'bold',
                                fontSize: 9
                            },
                        }]
                    }
                }
            });

            var ctx = this.$('.chart-donut').get(0).getContext('2d');
            var chartpie = new Chart(ctx ,{
                type: 'doughnut',
                data: {
                    labels: datos.chartareap.labels,
                    datasets: [{
                        backgroundColor: window.Misc.getColorsRGB(),
                        data: datos.chartareap.data
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Tiempo gastado por área.'
                    },
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
        }
    });

})(jQuery, this, this.document);
