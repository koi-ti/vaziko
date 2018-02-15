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
        events: {
            'click .add-funcionario': 'addFuncionario',
            'click .funcionario-remove': 'removeFuncionario',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$wraperfuncionarios = this.$('#render-funcionarios');
            this.count = 0;

            this.ready();
        },

        addFuncionario: function(e) {
            e.preventDefault();

            this.count += 1;
            var attributes = {count: this.count};

            this.$wraperfuncionarios.append( this.template(attributes) );
        },

        removeFuncionario: function(e) {
            e.preventDefault();

            var row = this.$(e.currentTarget).data('resource');
            this.$('#row_'+row).remove();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },
    });

})(jQuery, this, this.document);
