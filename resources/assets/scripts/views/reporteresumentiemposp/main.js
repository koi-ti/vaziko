/**
* Class MainReporteResumenTiempospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainReporteResumenTiempospView = Backbone.View.extend({

        el: '#rresumentiemposp-main',
        template: _.template( ($('#add-filter-funcionario-list').html() || '') ),
        events: {
            'click .add-funcionario': 'addFuncionario',
            'click .funcionario-remove': 'removeFuncionario',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Render row funcionarios
            this.$wraperfuncionarios = this.$('#render-funcionarios');
            this.count = 2;

            this.ready();
        },

        addFuncionario: function(e) {
            e.preventDefault();

            var posactual = this.count,
                attributes = {posactual: posactual};

            this.$wraperfuncionarios.append( this.template(attributes) );
            this.count++;
        },

        removeFuncionario: function(e) {
            e.preventDefault();

            var posactual = this.$(e.currentTarget).data('resource');
            this.$('#row_'+posactual).remove();
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
