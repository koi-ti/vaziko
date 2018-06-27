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
            'change .calculate_formula': 'changeFormula',
            'ifChanged #cotizacion2_tiro': 'changedTiro',
            'ifChanged #cotizacion2_retiro': 'changedRetiro',
            'click .submit-cotizacion2': 'submitCotizacion2',
            'change .event-price': 'calculateAll',
            'click .submit-cotizacion6': 'submitCotizacion6',
            'change #cotizacion6_areap': 'changeAreap',
            'submit #form-cotizacion-producto': 'onStore',
            'submit #form-cotizacion6-producto': 'onStoreCotizacion6'
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
            // _.bindAll(this, 'onSessionRequestComplete');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
                this.edit = false;

            if( this.model.id != undefined ){
                this.edit = true;
            }

            // Attributes
            this.maquinasProductopCotizacionList = new app.MaquinasProductopCotizacionList();
            this.materialesProductopCotizacionList = new app.MaterialesProductopCotizacionList();
            this.acabadosProductopCotizacionList = new app.AcabadosProductopCotizacionList();
            this.areasProductopCotizacionList = new app.AreasProductopCotizacionList();
            this.impresionesProductopCotizacionList = new app.ImpresionesProductopCotizacionList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'calculateAll', this.calculateAll );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = this.edit;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-cotizacion-producto');
            this.spinner = this.$('#spinner-main');

            this.$inputFormula = null;
            this.$inputRenderFormula = null;

            // Inputs render round
            this.$inputFormulaPrecio = this.$('#cotizacion2_precio_formula');
            this.$inputFormulaTransporte = this.$('#cotizacion2_transporte_formula');
            this.$inputFormulaViaticos = this.$('#cotizacion2_viaticos_formula');

            // Inputs render formulas
            this.$inputPrecio = this.$('#cotizacion2_precio_venta');
            this.$inputTranporte = this.$('#cotizacion2_transporte');
            this.$inputViaticos = this.$('#cotizacion2_viaticos');

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

            // Ordenp6
            this.$formCotizacion6 = this.$('#form-cotizacion6-producto');
            this.$inputArea = this.$('#cotizacion6_nombre');
            this.$inputTiempo = this.$('#cotizacion6_tiempo');
            this.$inputValor = this.$('#cotizacion6_valor');

            // Inputs cuadro de informacion
            this.$inputVolumen = this.$('#cotizacion2_volumen');
            this.$inputRound = this.$('#cotizacion2_round');
            this.$inputVcomision = this.$('#cotizacion2_vtotal');

            // Inputs from form
            this.$subtotal = this.$('#subtotal-price');
            this.$total = this.$('#total-price');
            this.$cantidad = this.$('#cotizacion2_cantidad');
            this.$precio = this.$('#cotizacion2_precio_venta');
            this.$viaticos = this.$('#cotizacion2_viaticos');
            this.$transporte = this.$('#cotizacion2_transporte');

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');
            this.$infoareas = this.$('#info-areas');

            // this.$uploaderFile = this.$('#fine-uploader');
            // if( !_.isNull( this.model.get('precotizacion2_id') ) ){
            //     this.uploadPictures();
            // }

            // Reference views
            this.calculateAll();
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

            // Materiales li, ateCotizacion2st
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
                model: this.model,
                parameters: {
                    dataFilter: dataFilter,
                    edit: true,
               }
            });

            this.impresionesProductopCotizacionListView = new app.ImpresionesProductopCotizacionListView( {
                collection: this.impresionesProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter,
               }
            });
        },

        /**
        * Event calcule formula
        */
        changeFormula: function (e) {
        	var _this = this,
                inputformula = this.$(e.currentTarget).data('input');

            if( inputformula == 'P' ){
                this.$inputFormula = this.$inputFormulaPrecio;
                this.$inputRenderFormula = this.$inputPrecio;

            }else if( inputformula == 'T' ){
                this.$inputFormula = this.$inputFormulaTransporte;
                this.$inputRenderFormula = this.$inputTranporte;

            }else if( inputformula == 'V' ){
                this.$inputFormula = this.$inputFormulaViaticos;
                this.$inputRenderFormula = this.$inputViaticos;

            }else{
                return;
            }

            var formula = this.$inputFormula.val();

            // sanitize input and replace
            formula = formula.replaceAll("(","n");
            formula = formula.replaceAll(")","m");
            formula = formula.replaceAll("+","t");

        	// Eval formula
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.productos.formula')),
                type: 'GET',
                data: {equation: formula},
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinner );
                _this.$inputRenderFormula.val(resp.precio_venta).trigger('change');
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
            	_this.$inputRenderFormula.val(0);
                window.Misc.removeSpinner( _this.spinner );
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

        // /**
        // * UploadPictures
        // */
        // uploadPictures: function(e) {
        //     var _this = this;
        //
        //     this.$uploaderFile.fineUploader({
        //         debug: false,
        //         template: 'qq-template',
        //         dragDrop: false,
        //         session: {
        //             endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
        //             params: {
        //                 precotizacion2: this.model.get('precotizacion2_id'),
        //             },
        //             refreshOnRequest: false
        //         },
        //         thumbnails: {
        //             placeholders: {
        //                 notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
        //                 waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
        //             }
        //         },
        //         callbacks: {
        //             onSessionRequestComplete: _this.onSessionRequestComplete,
        //         },
        //     });
        //
        //     this.$uploaderFile.find('.buttons').remove();
        //     this.$uploaderFile.find('.qq-upload-drop-area').remove();
        // },
        //
        // onSessionRequestComplete: function (id, name, resp) {
        //     _.each( id, function (value, key){
        //         var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
        //         previewLink.attr("href", value.thumbnailUrl);
        //     }, this);
        // },

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
                    data.cotizacion2_volumen = this.$inputVolumen.val();
                    data.cotizacion2_vtotal = this.$inputVcomision.inputmask('unmaskedvalue');
                    data.cotizacion2_total_valor_unitario = this.$total.inputmask('unmaskedvalue');
                    data.cotizacion2_round = this.$inputRound.val();
                    data.cotizacion6 = this.areasProductopCotizacionList.toJSON();

                this.model.save( data, {silent: true} );
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

                    _this.$inputArea.val('').attr('readonly', true);
                    _this.$inputTiempo.val('');
                    _this.$inputValor.val( resp.areap_valor );
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$inputArea.val('').attr('readonly', false);
                this.$inputTiempo.val('');
                this.$inputValor.val('');
            }
        },

        /**
        * Evento para calcular cotizacion
        **/
        calculateAll: function() {
            var cantidad = transporte = viaticos = areas = precio = volumen = total = subtotal =  vcomision = 0;

            // Igualar variables y quitar el inputmask
            cantidad = parseInt( this.$cantidad.val() );
            tranporte = Math.round( parseFloat( this.$transporte.inputmask('unmaskedvalue') ) / cantidad );
            viaticos = Math.round( parseFloat( this.$viaticos.inputmask('unmaskedvalue') ) / cantidad );
            areas = Math.round( parseFloat( this.areasProductopCotizacionList.totalize()['total'] ) / cantidad );
            precio = parseFloat( this.$precio.inputmask('unmaskedvalue') );
            volumen = parseInt( this.$inputVolumen.val() );

            // Cuadros de informacion
            this.$infoprecio.empty().html( window.Misc.currency( precio ) );
            this.$infoviaticos.empty().html( window.Misc.currency( viaticos ) );
            this.$infotransporte.empty().html( window.Misc.currency( tranporte ) );
            this.$infoareas.empty().html( window.Misc.currency( areas ) );

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            subtotal = precio + tranporte + viaticos + areas;
            vcomision = ( subtotal / ((100 - volumen ) / 100) ) * ( 1 - ((( 100 - volumen ) / 100 )));
            total = subtotal + vcomision;

            round = this.$inputRound.val();
            if( round <= 2 || round >= -2){
                // Calcular round decimales
                var exp = Math.pow(10, round);
                total = Math.round(total*exp)/exp;
            }else{
                return;
            }

            this.$subtotal.val( subtotal );
            this.$inputVcomision.val( vcomision );
            this.$total.val( total );
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
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );
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
