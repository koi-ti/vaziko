/**
* Init Class
*/

/*global*/
var app = app || {};

(function ($, window, document, undefined) {

    var InitComponent = function(){

        //Init Attributes
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    InitComponent.prototype = {

        /**
        * Constructor or Initialize Method
        */
        initialize: function () {
            //Initialize
            this.initApp();
            this.initICheck();
            this.initAlertify();
            this.initInputMask();
            this.initSelect2();
            this.initToUpper();
        },

        /**
        * Init Backbone Application
        */
        initApp: function () {
            window.app.AppRouter.start();
        },

        /**
        * Init icheck
        */
        initICheck: function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'            
            });
        },

        /**
        * Init alertify
        */
        initAlertify: function () {
            alertify.logPosition("bottom right");
        },

        /**
        * Init inputMask
        */
        initInputMask: function () {

            $("[data-mask]").inputmask();

            $("[data-currency]").inputmask({ 
                alias: 'decimal',
                autoGroup: true,
                digits: '2',
                groupSeparator: ',',
            });
        },

        /**
        * Init select2
        */
        initSelect2: function () {
            $('.select2-default').select2({ language: 'es', placeholder: 'Seleccione' });
            $('.select2-default-clear').select2({ language: 'es', placeholder: 'Seleccione', allowClear: true });
        },

        /**
        * Init toUpper
        */
        initToUpper: function () {
            $('.input-toupper').keyup(function(){
                $(this).val( $(this).val().toUpperCase() );
            });
        }
    };

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();
    });

})(jQuery, this, this.document);
