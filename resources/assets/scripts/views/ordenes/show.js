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
        templateEmpleado: _.template( ($('#chart-empleado-ordenp').html() || '') ),
        templateAreap: _.template( ($('#chart-areasp-ordenp').html() || '') ),
        templateProductop: _.template( ($('#chart-productop-ordenp').html() || '') ),
        events: {
            'click .export-ordenp': 'exportOrdenp',
            'click .open-ordenp': 'openOrdenp',
            'click .close-ordenp': 'closeOrdenp',
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

            // Render rows charts
            this.$renderChartEmpleado = this.$('#render-chart-empleado');
            this.$renderChartAreasp = this.$('#render-chart-areasp');
            this.$renderChartProductop = this.$('#render-chart-productop');

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

        charts: function ( resp ){
            // Definir opciones globales para graficas del modulo
            Chart.defaults.global.defaultFontColor="black";
            Chart.defaults.global.defaultFontStyle="bold";
            Chart.defaults.global.defaultFontSize=9;
            Chart.defaults.global.title.fontSize=12;

            function formatTime( timeHour ){
                var dias = Math.floor( timeHour / 24 );
                var horas = Math.floor( timeHour - ( dias * 24 ) );
                var minutos = Math.floor( ( timeHour - (dias * 24) - (horas) ) * 60 );

                return dias+"d "+horas+"h "+minutos+"m";
            }

            // Chart empleado
            if ( !_.isEmpty( resp.chartempleado.data ) ) {
                this.$renderChartEmpleado.html( this.templateEmpleado() );

                var ctx = this.$('#chart_empleado').get(0).getContext('2d');
                var green_black_gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    green_black_gradient.addColorStop(0, 'green');
                    green_black_gradient.addColorStop(1, 'black');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: resp.chartempleado.labels,
                        datasets: [{
                            label: 'tiempo empleado',
                            data: resp.chartempleado.data,
                            backgroundColor: green_black_gradient,
                            hoverBackgroundColor: green_black_gradient,
                            hoverBorderWidth: 2,
                            hoverBorderColor: 'white'
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        legend: { display: false },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                barThickness: 60,
                                barPercentage: 1.,
                                categoryPercentage: .5,
                                gridLines: {
                                    offsetGridLines: true
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Horas'
                                },
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    return data.datasets[item.datasetIndex].label+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        }
                    }
                });
            }
            if ( !_.isEmpty( resp.chartareap.data ) ) {
                this.$renderChartAreasp.html( this.templateAreap() );

                var ctx = this.$('#chart_areas').get(0).getContext('2d');
                new Chart(ctx ,{
                    type: 'doughnut',
                    data: {
                        labels: resp.chartareap.labels,
                        datasets: [{
                            backgroundColor: window.Misc.getColorsRGB(),
                            data: resp.chartareap.data
                        }]
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
                                    return data.labels[item.index]+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        },
                    }
                });
            }
            if ( !_.isEmpty( resp.chartcomparativa.labels ) ){
                this.$renderChartProductop.html( this.templateProductop() );

                var ctx = this.$('#chart_comparativa').get(0).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: resp.chartcomparativa.labels,
                        datasets: [
                            {
                                label: 'Tiempo de producción',
                                data: resp.chartcomparativa.tiempoproduction,
                                backgroundColor: '#00A65A',
                                hoverBackgroundColor: '#00A65A',
                                hoverBorderWidth: 1,
                                hoverBorderColor: 'black'
                            },{
                                label: 'Tiempo cotizado',
                                data: resp.chartcomparativa.tiempocotizacion,
                                backgroundColor: '#D8D8D8',
                                hoverBackgroundColor: '#D8D8D8',
                                hoverBorderWidth: 1,
                                hoverBorderColor: 'black'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        scales: {
                            xAxes: [{
                                barPercentage: 1.,
                                categoryPercentage: .4,
                                gridLines: {
                                    offsetGridLines: true
                                },
                                ticks: {
                                    autoSkip: false
                                 }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Horas'
                                },
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    return data.datasets[item.datasetIndex].label+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        },
                    }
                });
            }

            this.$('.tiempo-total').text( formatTime(resp.tiempototal) );
            this.$('.orden-codigo').text( resp.orden_codigo );
        }
    });

})(jQuery, this, this.document);
