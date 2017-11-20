/**
* Class CreateTiempopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTiempopView = Backbone.View.extend({

        el: '#tiempop-create',
        template: _.template( ($('#add-tiempop-tpl').html() || '') ),
        events: {
            'click .submit-tiempop': 'submitTiempop',
            'click .btn-edit-tiempop': 'editTiempop',
            'submit #form-tiempop': 'onStoreTiempop',
            'change #tiempop_actividadop': 'changeActividadOp'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-tiempop');
            this.$modal = $('#modal-edit-tiempop');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // Attributes
            this.$form = this.$('#form-tiempop');
            this.$subactividadesop = this.$('#tiempop_subactividadop');

            this.ready();
        },

        /**
        * Event change select actividadop
        */
        changeActividadOp: function(e) {
            var _this = this,
                actividadesop = this.$(e.currentTarget).val();

            if( typeof(actividadesop) !== 'undefined' && !_.isUndefined(actividadesop) && !_.isNull(actividadesop) && actividadesop != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subactividadesop.index', {actividadesop: actividadesop}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );

                    if(resp.length > 0){
                        _this.$subactividadesop.empty().val(0).attr('required', 'required');
                        _this.$subactividadesop.append("<option value=></option>");
                        _.each(resp, function(item){
                            _this.$subactividadesop.append("<option value="+item.id+">"+item.subactividadop_nombre+"</option>");
                        });
                    }else{
                        _this.$subactividadesop.empty().val(0).removeAttr('required');
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }else{
                this.$subactividadesop.empty().val(0);
            }
        },

        /**
        * Event submit productop
        */
        submitTiempop: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Forum Post
        */
        onStoreTiempop: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true} );
            }
        },

        editTiempop: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var tiempo = {
                    id: this.$(e.currentTarget).data('tiempo-id'),
                    fecha: this.$(e.currentTarget).data('tiempo-fecha'),
                    horai: this.$(e.currentTarget).data('tiempo-hi'),
                    horaf: this.$(e.currentTarget).data('tiempo-hf')
                };

                this.$modal.modal('show');

                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.tiempopActionView = new app.TiempopActionView({
                    model: this.model,
                    parameters: {
                        model: tiempo
                    }
                });

                this.tiempopActionView.render();
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
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

                window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route('tiemposp.index')) );
	     	}
        }
    });

})(jQuery, this, this.document);
