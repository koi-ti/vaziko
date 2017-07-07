/**
* Class EditCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        templateFp: _.template( ($('#add-detalle-cotizacion-tpl').html() || '') ),
      	templateCP: _.template( ($('#add-producto-cotizacion-tpl').html() || '') ),
      	templateCM: _.template( ($('#add-material-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'submit #form-cotizacion': 'onStore',

            'submit #form-cotizacion3': 'onStoreItem3',
            'change #cotizacion3_areap': 'changeAreap',

            //Event Option cotizacion
            'click .aprobar-cotizacion': 'approveCotizacion',
            'click .anular-cotizacion': 'cancelCotizacion',

            'click .add-producto': 'addProducto',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Initialize
            this.$modalProducto = $('#modal-producto-component');

            this.detalleCotizacion2 = new app.DetalleCotizacion2List();
            this.detalleCotizacion3 = new app.DetalleCotizacion3List();

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$wrapperDetalle = this.$('#render-detalle');
            this.$wrapperDetalle.html( this.templateFp({}) );

            this.$form = this.$('#form-cotizacion');
            this.$nombreC3 = this.$('#cotizacion3_nombre');
            this.$valorC3 = this.$('#cotizacion3_valor');

            // Spinner
            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

            // to fire plugins
            this.ready();
		},

        /**
        * Event submit Asiento
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        addProducto: function(e){
        	var text = this.$(e.target).text().trim();
            this.call = null;

            if (text == 'Producto'){
                this.$modalProducto.find('.modal-title').text( 'Cotización - ' + text );
                this.$modalProducto.find('.content-modal').html( this.templateCP() );
                this.call = 'P';
            }else if( text == 'Material'){
                this.$modalProducto.find('.modal-title').text( 'Cotización - ' + text );
                this.$modalProducto.find('.content-modal').html( this.templateCM() );
                this.call = 'M';
            }else{
        		return;
        	}

    		this.$modalProducto.modal('show');
    		this.ready();

            // productosView undelegateEvents
            if ( this.productosView instanceof Backbone.View ){
                this.productosView.stopListening();
                this.productosView.undelegateEvents();
            }

            this.productosView = new app.ProductosView({
            	collection: this.detalleCotizacion2,
            	parameters:{
	            	cotizacion: this.model.get('id'),
                    call: this.call,
            	}
            });

            this.productosView.render();
        },


        /**
        * Event Create cotizacion
        */
        onStoreItem3: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                    data.cotizacion1 = this.model.get('id');
                this.detalleCotizacion3.trigger( 'store' , data );
            }
        },

        changeAreap: function(e){
            var _this = this;
                id = this.$(e.currentTarget).val();
            
            this.$nombreC3.val('');
            
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

                    _this.$nombreC3.attr('readonly', true);
                    _this.$valorC3.val( resp.areap_valor );
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                _this.$nombreC3.attr('readonly', false);
            }
        },

        /**
        * cancel cotizacion
        */
        cancelCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelCotizacion = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-cancel-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular cotizacion',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.cancel', { cotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.show', { cotizaciones: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelCotizacion.render();
        },

        approveCotizacion: function(e){
            e.preventDefault();

            var _this = this;
            var approveCotizacion = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-approve-confirm-tpl').html() || '') ),
                    titleConfirm: 'Aprobar cotizacion',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.approve', { cotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.show', { cotizaciones: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            approveCotizacion.render();

        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle cotizacion2 list
            this.detalleCotizacion2ListView = new app.DetalleCotizacion2ListView({
                collection: this.detalleCotizacion2,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    model: this.model,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });

            // Detalle cotizacion3 list
            this.detalleCotizacion3ListView = new app.DetalleCotizacion3ListView({
                collection: this.detalleCotizacion3,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

				// Redirect to show view                
				window.Misc.redirect( window.Misc.urlFull( Route.route('cotizaciones.edit', { cotizaciones: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);
