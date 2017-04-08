/**
* Class CreateOrdenp2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenp2View = Backbone.View.extend({

        el: '#ordenes-productos-create',
        template: _.template( ($('#add-orden-producto-tpl').html() || '') ),
        events: {
            'change #orden2_precio_formula': 'changeFormula',
            'change #orden2_round_formula': 'changeFormula',
            'ifChanged #orden2_tiro': 'changedTiro',
            'ifChanged #orden2_retiro': 'changedRetiro',
            'click .submit-ordenp2': 'submitOrdenp2',
            'submit #form-orden-producto': 'onStore'
        },
        parameters: {
            data: {
                orden2_productop: null
            }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-orden-producto');
            this.maquinasProductopList = new app.MaquinasProductopList();
            this.materialesProductopList = new app.MaterialesProductopList();
            this.acabadosProductopList = new app.AcabadosProductopList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-orden-producto');
            this.$inputFormula = this.$('#orden2_precio_formula');
            this.$inputRound = this.$('#orden2_round_formula');
            this.$inputPrecio = this.$('#orden2_precio_venta');

            // Tiro
            this.$inputYellow = this.$('#orden2_yellow');
            this.$inputMagenta = this.$('#orden2_magenta');
            this.$inputCyan = this.$('#orden2_cyan');
            this.$inputKey = this.$('#orden2_key');

            // Retiro
            this.$inputYellow2 = this.$('#orden2_yellow2');
            this.$inputMagenta2 = this.$('#orden2_magenta2');
            this.$inputCyan2 = this.$('#orden2_cyan2');
            this.$inputKey2 = this.$('#orden2_key2');

            // Reference views
            this.referenceViews();

            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.orden2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.orden2 = this.model.get('id');
                dataFilter.productop = this.model.get('orden2_productop');
            }

            // Maquinas list
            this.maquinasProductopListView = new app.MaquinasProductopListView( {
                collection: this.maquinasProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.materialesProductopListView = new app.MaterialesProductopListView( {
                collection: this.materialesProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.acabadosProductopListView = new app.AcabadosProductopListView( {
                collection: this.acabadosProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });
        },

        /**
        * Event calcule formula
        */
        changeFormula: function () {
        	var _this = this;
        	var formula = this.$inputFormula.val();
        	var round = this.$inputRound.val();

        	// sanitize input and replace
        	formula = formula.replaceAll("(","n");
        	formula = formula.replaceAll(")","m");
        	formula = formula.replaceAll("+","t");

        	// Eval formula
            $.ajax({
                url: window.Misc.urlFull(Route.route('ordenes.productos.formula')),
                type: 'GET',
                data: { equation: formula, round: round },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                _this.$inputPrecio.val(resp.precio_venta);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
            	_this.$inputPrecio.val(0);
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        changedTiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow.iCheck('check');
                this.$inputMagenta.iCheck('check');
                this.$inputCyan.iCheck('check');
                this.$inputKey.iCheck('check');
            }else{
                this.$inputYellow.iCheck('uncheck');
                this.$inputMagenta.iCheck('uncheck');
                this.$inputCyan.iCheck('uncheck');
                this.$inputKey.iCheck('uncheck');
            }
        },

        changedRetiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow2.iCheck('check');
                this.$inputMagenta2.iCheck('check');
                this.$inputCyan2.iCheck('check');
                this.$inputKey2.iCheck('check');
            }else{
                this.$inputYellow2.iCheck('uncheck');
                this.$inputMagenta2.iCheck('uncheck');
                this.$inputCyan2.iCheck('uncheck');
                this.$inputKey2.iCheck('uncheck');
            }
        },

        /**
        * Event submit productop
        */
        submitOrdenp2: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.model.save( data, {silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

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

                // Redirect to orden
                window.Misc.redirect( window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: this.model.get('orden2_orden') })) );
            }
        }
    });

})(jQuery, this, this.document);
