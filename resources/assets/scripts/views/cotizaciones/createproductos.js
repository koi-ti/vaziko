/**
* Class CreateCotizacion2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacion2View = Backbone.View.extend({

        el: '#cotizaciones-productos-create',
        template: _.template( ($('#add-cotizacion-producto-tpl').html() || '') ),
        events: {
            'change #cotizacion2_precio_formula': 'changeFormula',
            'change #cotizacion2_round_formula': 'changeFormula',
            'ifChanged #cotizacion2_tiro': 'changedTiro',
            'ifChanged #cotizacion2_retiro': 'changedRetiro',
            'click .submit-cotizacion2': 'submitCotizacion2',
            'submit #form-cotizacion-producto': 'onStore',
            'click .submit-cotizacion6': 'submitCotizacion6',
            'change #cotizacion6_areap': 'changeAreap',
            'submit #form-cotizacion6-producto': 'onStoreCotizacion6',
            'change .event-price': 'calculateCotizacion2',
        },
        parameters: {
            data: {
                cotizacion2_productop: null
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
            this.$wraperForm = this.$('#render-form-cotizacion-producto');
            this.maquinasProductopCotizacionList = new app.MaquinasProductopCotizacionList();
            this.materialesProductopCotizacionList = new app.MaterialesProductopCotizacionList();
            this.acabadosProductopCotizacionList = new app.AcabadosProductopCotizacionList();
            this.areasProductopCotizacionList = new app.AreasProductopCotizacionList();

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

            this.$form = this.$('#form-cotizacion-producto');
            this.$inputFormula = this.$('#cotizacion2_precio_formula');
            this.$inputRound = this.$('#cotizacion2_round_formula');
            this.$inputPrecio = this.$('#cotizacion2_precio_venta');

            // Tiro
            this.$inputYellow = this.$('#cotizacion2_yellow');
            this.$inputMagenta = this.$('#cotizacion2_magenta');
            this.$inputCyan = this.$('#cotizacion2_cyan');
            this.$inputKey = this.$('#cotizacion2_key');

            // Retiro
            this.$inputYellow2 = this.$('#cotizacion2_yellow2');
            this.$inputMagenta2 = this.$('#cotizacion2_magenta2');
            this.$inputCyan2 = this.$('#cotizacion2_cyan2');
            this.$inputKey2 = this.$('#cotizacion2_key2');

            // Cotizacion6
            this.$formCotizacion6 = this.$('#form-cotizacion6-producto');
            this.$nombreC6 = this.$('#cotizacion6_nombre');
            this.$horasC6 = this.$('#cotizacion6_horas');
            this.$valorC6 = this.$('#cotizacion6_valor');

            // Total
            this.$precioCot2 = this.$('#total-price');
            this.$precio = this.$('#cotizacion2_precio_venta');
            this.$viaticos = this.$('#cotizacion2_viaticos');
            this.$transporte = this.$('#cotizacion2_transporte');
            this.totalAreap = 0;
            this.$totalCot = 0;

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');

            // Reference views
            this.calculateCotizacion2();
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.cotizacion2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.cotizacion2 = this.model.get('id');
                dataFilter.productop = this.model.get('cotizacion2_productop');
            }

            // Maquinas list
            this.maquinasProductopCotizacionListView = new app.MaquinasProductopCotizacionListView( {
                collection: this.maquinasProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.materialesProductopCotizacionListView = new app.MaterialesProductopCotizacionListView( {
                collection: this.materialesProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.acabadosProductopCotizacionListView = new app.AcabadosProductopCotizacionListView( {
                collection: this.acabadosProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Areasp list
            this.areasProductopCotizacionListView = new app.AreasProductopCotizacionListView( {
                collection: this.areasProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter,
                    edit: true,
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
                url: window.Misc.urlFull(Route.route('cotizaciones.productos.formula')),
                type: 'GET',
                data: { equation: formula, round: round },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                _this.$inputPrecio.val(resp.precio_venta);
                _this.calculateCotizacion2();
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
        submitCotizacion2: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.cotizacion6 = this.areasProductopCotizacionList.toJSON();
                this.model.save( data, {silent: true} );
            }
        },

        calculateCotizacion2: function() {
            this.totalAreap = this.areasProductopCotizacionList.trigger('reset').totalize();
            this.$totalCot = parseFloat( this.$precio.inputmask('unmaskedvalue') ) + parseFloat( this.$viaticos.inputmask('unmaskedvalue') ) + parseFloat( this.$transporte.inputmask('unmaskedvalue') + parseFloat(this.totalAreap.total) );

            console.log(this.areasProductopCotizacionList.trigger('reset'));

            this.$infoprecio.empty().html( window.Misc.currency( this.$precio.inputmask('unmaskedvalue')) );
            this.$infoviaticos.empty().html( window.Misc.currency( this.$viaticos.inputmask('unmaskedvalue')) );
            this.$infotransporte.empty().html( window.Misc.currency( this.$transporte.inputmask('unmaskedvalue')) );

            this.$precioCot2.val( this.$totalCot );
        },

        /**
        *   Event render input value
        **/
        changeAreap: function(e){
           var _this = this;
               id = this.$(e.currentTarget).val();

           if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ){
               $.ajax({
                   url: window.Misc.urlFull( Route.route('areasp.show', {areasp: id}) ),
                   type: 'GET',
                   beforeSend: function() {
                       window.Misc.setSpinner( _this.spinner );
                   }
               })
               .done(function(resp) {
                   window.Misc.removeSpinner( _this.spinner );

                   _this.$nombreC6.val('').attr('readonly', true);
                   _this.$horasC6.val('');
                   _this.$valorC6.val( resp.areap_valor );
               })
               .fail(function(jqXHR, ajaxOptions, thrownError) {
                   window.Misc.removeSpinner( _this.spinner );
                   alertify.error(thrownError);
               });
           }else{
              this.$nombreC6.val('').attr('readonly', false);
              this.$valorC6.val('');
              this.$horasC6.val('');
           }
        },

        /**
        * Event submit productop
        */
        submitCotizacion6: function (e) {
            this.$formCotizacion6.submit();
        },

        /**
        * Event Create Folder
        */
        onStoreCotizacion6: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopCotizacionList.trigger( 'store' , data );
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

                // Redirect to cotizacion
                window.Misc.redirect( window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: this.model.get('cotizacion2_cotizacion') })) );
            }
        }
    });

})(jQuery, this, this.document);
