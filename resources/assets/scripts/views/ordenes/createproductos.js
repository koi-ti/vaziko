/**
* Class CreateOrdenp2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenp2View = Backbone.View.extend({

        el: '#create-ordenp-producto',
        template: _.template( ($('#add-orden-producto-tpl').html() || '') ),
        events: {
            'change .calculate_formula': 'changeFormula',
            'ifChanged #orden2_tiro': 'changedTiro',
            'ifChanged #orden2_retiro': 'changedRetiro',
            'click .submit-ordenp2': 'submitOrdenp2',
            'submit #form-orden-producto': 'onStore',
            'click .submit-ordenp6': 'submitOrdenp6',
            'submit #form-ordenp6-producto': 'onStoreOrdenp6',
            'change #orden6_areap': 'changeAreap',
            'change .event-price': 'calculateOrdenp2',
            'ifChanged #orden2_round': 'roundComision'
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
            _.bindAll(this, 'onSessionRequestComplete');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
                this.edit = false;

            if( this.model.id != undefined ){
                this.edit = true;
            }

            // Attributes
            this.maquinasProductopList = new app.MaquinasProductopList();
            this.materialesProductopList = new app.MaterialesProductopList();
            this.acabadosProductopList = new app.AcabadosProductopList();
            this.areasProductopList = new app.AreasProductopList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'calculateOrdenp2', this.calculateOrdenp2 );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = this.edit;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-orden-producto');
            this.spinner = this.$('#spinner-main');

            this.$inputFormula = null;
            this.$inputRenderFormula = null;

            // Inputs render round
            this.$inputFormulaPrecio = this.$('#orden2_precio_formula');
            this.$inputFormulaTransporte = this.$('#orden2_transporte_formula');
            this.$inputFormulaViaticos = this.$('#orden2_viaticos_formula');

            // Inputs render formulas
            this.$inputPrecio = this.$('#orden2_precio_venta');
            this.$inputTranporte = this.$('#orden2_transporte');
            this.$inputViaticos = this.$('#orden2_viaticos');

            this.$inputFormula = this.$('#orden2_precio_formula');
            this.$inputPrecio = this.$('#orden2_precio_venta');

            // Tiro
            this.$inputYellow = this.$('#orden2_yellow');
            this.$inputMagenta = this.$('#orden2_magenta');
            this.$inputCyan = this.$('#orden2_cyan');
            this.$inputKey = this.$('#orden2_key');
            this.$inputColor1 = this.$('#orden2_color1');
            this.$inputColor2 = this.$('#orden2_color2');

            // Retiro
            this.$inputYellow2 = this.$('#orden2_yellow2');
            this.$inputMagenta2 = this.$('#orden2_magenta2');
            this.$inputCyan2 = this.$('#orden2_cyan2');
            this.$inputKey2 = this.$('#orden2_key2');
            this.$inputColor12 = this.$('#orden2_color12');
            this.$inputColor22 = this.$('#orden2_color22');

            // Ordenp6
            this.$formOrdenp6 = this.$('#form-ordenp6-producto');
            this.$inputArea = this.$('#orden6_nombre');
            this.$inputTiempo = this.$('#orden6_tiempo');
            this.$inputValor = this.$('#orden6_valor');

            // Inputs cuadro de informacion
            this.$inputVolumen = this.$('#orden2_volumen');
            this.$checkRound = this.$('#orden2_round');
            this.$inputVcomision = this.$('#orden2_vtotal');

            // Inputs from form
            this.$subtotal = this.$('#subtotal-price');
            this.$total = this.$('#total-price');
            this.$cantidad = this.$('#orden2_cantidad');
            this.$precio = this.$('#orden2_precio_venta');
            this.$viaticos = this.$('#orden2_viaticos');
            this.$transporte = this.$('#orden2_transporte');

            // Fine uploader
            this.$uploaderFile = this.$('#fine-uploader');

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');
            this.$infoareas = this.$('#info-areas');

            if( !_.isNull( this.model.get('precotizacion2_id') ) ){
                this.uploadPictures();
            }

            // Reference views
            this.calculateOrdenp2();
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

            // Areas list
            this.areasProductopListView = new app.AreasProductopListView( {
                collection: this.areasProductopList,
                parameters: {
                    dataFilter: dataFilter,
                    model: this.model,
                    edit: true
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
                url: window.Misc.urlFull(Route.route('ordenes.productos.formula')),
                type: 'GET',
                data: { equation: formula },
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
                this.$inputColor1.iCheck('check');
                this.$inputColor2.iCheck('check');
            }else{
                this.$inputYellow.iCheck('uncheck');
                this.$inputMagenta.iCheck('uncheck');
                this.$inputCyan.iCheck('uncheck');
                this.$inputKey.iCheck('uncheck');
                this.$inputColor1.iCheck('uncheck');
                this.$inputColor2.iCheck('uncheck');
            }
        },

        changedRetiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow2.iCheck('check');
                this.$inputMagenta2.iCheck('check');
                this.$inputCyan2.iCheck('check');
                this.$inputKey2.iCheck('check');
                this.$inputColor12.iCheck('check');
                this.$inputColor22.iCheck('check');
            }else{
                this.$inputYellow2.iCheck('uncheck');
                this.$inputMagenta2.iCheck('uncheck');
                this.$inputCyan2.iCheck('uncheck');
                this.$inputKey2.iCheck('uncheck');
                this.$inputColor12.iCheck('uncheck');
                this.$inputColor22.iCheck('uncheck');
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
                    data.orden2_volumen = this.$inputVolumen.val();
                    data.orden2_vtotal = this.$inputVcomision.inputmask('unmaskedvalue');
                    data.orden2_total_valor_unitario = this.$total.inputmask('unmaskedvalue');
                    data.orden2_round = this.$checkRound.is(':checked');
                    data.ordenp6 = this.areasProductopList.toJSON();

                this.model.save( data, {silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitOrdenp6: function (e) {
            this.$formOrdenp6.submit();
        },

        /**
        * Event Create Folder
        */
        onStoreOrdenp6: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopList.trigger( 'store' , data );
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
        *   Event calculate orden2
        **/
        calculateOrdenp2: function () {
            var cantidad = transporte = viaticos = areas = precio = volumen = total = subtotal =  vcomision = 0;

            // Igualar variables y quitar el inputmask
            cantidad = parseInt( this.$cantidad.val() );
            tranporte = Math.round( parseFloat( this.$transporte.inputmask('unmaskedvalue') ) / cantidad  );
            viaticos = Math.round( parseFloat( this.$viaticos.inputmask('unmaskedvalue') ) / cantidad  );
            areas = Math.round( parseFloat( this.areasProductopList.totalize()['total'] ) / cantidad  );
            precio = parseFloat( this.$precio.inputmask('unmaskedvalue') );
            volumen = parseInt( this.$inputVolumen.val() );

            // Cuadros de informacion
            this.$infoprecio.empty().html( window.Misc.currency( precio ) );
            this.$infoviaticos.empty().html( window.Misc.currency( viaticos ) );
            this.$infotransporte.empty().html( window.Misc.currency( tranporte ) );
            this.$infoareas.empty().html( window.Misc.currency( areas ) );

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            subtotalordenp2 = precio + tranporte + viaticos + areas;
            vcomision = ( subtotalordenp2 / ((100 - volumen ) / 100) ) * ( 1 - ((( 100 - volumen ) / 100 )));

            if( this.$checkRound.is(':checked') ) {
                total = Math.round( subtotalordenp2 + vcomision );
            }else{
                total = subtotalordenp2 + vcomision;
            }

            this.$subtotal.val( subtotalordenp2 );
            this.$inputVcomision.val( vcomision );
            this.$total.val( total );
        },

        /**
        * Call event calculate change checkbox
        **/
        roundComision: function(e) {
           this.calculateOrdenp2();
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
                    params: {
                        precotizacion2: this.model.get('precotizacion2_id'),
                    },
                    refreshOnRequest: false
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });

            this.$uploaderFile.find('.buttons').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
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

                // Redirect to orden
                window.Misc.redirect( window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: this.model.get('orden2_orden') })) );
            }
        }
    });

})(jQuery, this, this.document);
