/**
* Class MainReporteTiempospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainReporteTiempospView = Backbone.View.extend({

        el: '#rtiemposp-main',
        template: _.template( ($('#add-funcionario-list').html() || '') ),
        templateCharts: _.template( ($('#add-rtiempop-charts').html() || '') ),
        events: {
            'click .add-funcionario': 'addFuncionario',
            'click .funcionario-remove': 'removeFuncionario',
            'submit #form-rtiemposp': 'onGenerateChart',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Render row funcionarios
            this.$wraperfuncionarios = this.$('#render-funcionarios');
            this.$wrapercharts = $('#render-chart');
            this.count = 0;

            this.ready();
        },

        addFuncionario: function(e) {
            e.preventDefault();

            this.count++;
            var attributes = {count: this.count};

            this.$wraperfuncionarios.append( this.template(attributes) );
        },

        removeFuncionario: function(e) {
            e.preventDefault();

            var row = this.$(e.currentTarget).data('resource');
            this.$('#row_'+row).remove();
            this.count--;
        },

        onGenerateChart: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this,
                    data = window.Misc.formToJson( e.target );

                switch (data.type) {
                    case 'pdf':
                        window.Misc.redirect( window.Misc.urlFull(Route.route('rtiemposp.exportar', data)) );
                        break;
                    case 'chart':

                        $.ajax({
                            url: window.Misc.urlFull( Route.route('rtiemposp.charts') ),
                            type: 'GET',
                            data: data,
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el);
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

                                _this.referenceCharts( resp );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                        break;
                }
            }
        },

        referenceCharts: function( resp ) {
            this.$wrapercharts.html( this.templateCharts() );

            function formatTime( timeHour ){
                var dias = Math.floor( timeHour / 24 );
                var horas = Math.floor( timeHour - ( dias * 24 ) );
                var minutos = Math.floor( ( timeHour - (dias * 24) - (horas) ) * 60 );

                return dias+"d "+horas+"h "+minutos+"m";
            }

            var ctx = $('#chart_funcionario').get(0).getContext('2d');
            var green_black_gradient = ctx.createLinearGradient(0, 0, 0, 300);
                green_black_gradient.addColorStop(0, 'green');
                green_black_gradient.addColorStop(1, 'black');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: resp.chart.labels,
                    datasets: [{
                        label: 'tiempo empleado',
                        data: resp.chart.data,
                        backgroundColor: green_black_gradient,
                        hoverBackgroundColor: green_black_gradient,
                        hoverBorderWidth: 2,
                        hoverBorderColor: 'black'
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Tiempo empleado por funcionario.'
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
                            },
                            ticks: {
                                autoSkip: false
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
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },
    });

})(jQuery, this, this.document);
